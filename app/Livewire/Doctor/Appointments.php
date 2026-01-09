<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use App\Models\User;

#[Layout('components.layouts.doctor')] // Create this layout if needed
class Appointments extends Component
{
    public $pendingAppointments = [];
    public $upcomingAppointments = [];
    public $pastAppointments = [];
    
    public $selectedAppointment;
    public $showAppointmentModal = false;
    public $appointmentNotes;

    public function mount()
    {
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $doctorId = auth()->id();
        
        // Pending appointments waiting for approval
        $this->pendingAppointments = Appointment::with(['patient', 'patient.userDetails'])
            ->where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->orderBy('scheduled_at', 'asc')
            ->get()
            ->toArray();

        // Upcoming confirmed appointments
        $this->upcomingAppointments = Appointment::with(['patient', 'patient.userDetails'])
            ->where('doctor_id', $doctorId)
            ->where('status', 'confirmed')
            ->where('scheduled_at', '>=', now()->startOfDay())
            ->orderBy('scheduled_at', 'asc')
            ->get()
            ->toArray();

        // Past appointments
        $this->pastAppointments = Appointment::with(['patient', 'patient.userDetails'])
            ->where('doctor_id', $doctorId)
            ->where('doctor_id', $doctorId)
            ->where(function($query) {
                $query->where('status', 'completed')
                      ->orWhere('status', 'cancelled');
            })
            ->orderBy('scheduled_at', 'desc')
            ->get()
            ->toArray();
    }

    public function viewAppointment($appointmentId)
    {
        $this->selectedAppointment = Appointment::with(['patient', 'patient.userDetails'])
            ->where('doctor_id', auth()->id())
            ->find($appointmentId);
            
        $this->showAppointmentModal = true;
    }

    public function approveAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::where('doctor_id', auth()->id())
                ->where('id', $appointmentId)
                ->first();

            if ($appointment) {
                \DB::beginTransaction();
                try {
                    $appointment->update([
                        'status' => 'confirmed',
                        'notes' => $this->appointmentNotes
                    ]);

                    // Transfer payment to doctor wallet now that appointment is approved
                    if ($appointment->fee > 0 && $appointment->payment_status === 'pending') {
                        $doctor = $appointment->doctor;
                        $patient = $appointment->patient;
                        $fee = $appointment->fee;

                        // Compute commission and net amounts
                        $commissionPercent = floatval(config('payments.platform_commission', 0.10));
                        $commission = round($fee * $commissionPercent, 2);
                        $netToDoctor = round($fee - $commission, 2);

                        // Credit doctor with net amount
                        $doctorWallet = $doctor->getOrCreateWallet();
                        $doctorWallet->balance = $doctorWallet->balance + $netToDoctor;
                        $doctorWallet->save();

                        \App\Models\WalletTransaction::create([
                            'wallet_id' => $doctorWallet->id,
                            'type' => 'credit',
                            'amount' => $netToDoctor,
                            'description' => 'Appointment payment (net) - Patient: ' . $patient->name,
                            'status' => 'completed',
                            'appointment_id' => $appointment->id,
                        ]);

                        // Credit platform commission to admin wallet
                        $platformOwner = \App\Models\User::where('role', 'admin')->first();
                        if ($platformOwner) {
                            $platformWallet = $platformOwner->getOrCreateWallet();
                            $platformWallet->balance = $platformWallet->balance + $commission;
                            $platformWallet->save();

                            \App\Models\WalletTransaction::create([
                                'wallet_id' => $platformWallet->id,
                                'type' => 'credit',
                                'amount' => $commission,
                                'description' => 'Platform commission - Appointment #' . $appointment->id,
                                'status' => 'completed',
                                'appointment_id' => $appointment->id,
                            ]);
                        }

                        // Update patient transaction status from pending to completed
                        \App\Models\WalletTransaction::where('appointment_id', $appointment->id)
                            ->where('type', 'debit')
                            ->where('status', 'pending')
                            ->update(['status' => 'completed', 'description' => 'Appointment payment - Dr. ' . $doctor->name]);

                        // Mark payment as paid
                        $appointment->update(['payment_status' => 'paid']);
                    }

                    \DB::commit();
                    session()->flash('message', 'Appointment approved successfully.');
                    $this->closeModal();
                    $this->loadAppointments();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to approve appointment: ' . $e->getMessage());
        }
    }

    public function rejectAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::where('doctor_id', auth()->id())
                ->where('id', $appointmentId)
                ->first();

            if ($appointment) {
                \DB::beginTransaction();
                try {
                    $appointment->update([
                        'status' => 'cancelled',
                        'notes' => $this->appointmentNotes
                    ]);

                    // Refund patient if payment was held
                    if ($appointment->fee > 0 && $appointment->payment_status === 'pending') {
                        $patient = $appointment->patient;
                        $patientWallet = $patient->getOrCreateWallet();
                        $fee = $appointment->fee;

                        // Refund the full amount back to patient
                        $patientWallet->balance = $patientWallet->balance + $fee;
                        $patientWallet->save();

                        \App\Models\WalletTransaction::create([
                            'wallet_id' => $patientWallet->id,
                            'type' => 'credit',
                            'amount' => $fee,
                            'description' => 'Appointment refund - Rejected by Dr. ' . $appointment->doctor->name,
                            'status' => 'completed',
                            'appointment_id' => $appointment->id,
                        ]);

                        // Update the original debit transaction status
                        \App\Models\WalletTransaction::where('appointment_id', $appointment->id)
                            ->where('type', 'debit')
                            ->where('status', 'pending')
                            ->update([
                                'status' => 'failed',
                                'description' => 'Appointment cancelled - Refunded by Dr. ' . $appointment->doctor->name
                            ]);

                        // Mark payment as refunded
                        $appointment->update(['payment_status' => 'refunded']);
                    }

                    \DB::commit();
                    session()->flash('message', 'Appointment rejected and payment refunded successfully.');
                    $this->closeModal();
                    $this->loadAppointments();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reject appointment: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showAppointmentModal = false;
        $this->selectedAppointment = null;
        $this->appointmentNotes = null;
    }

    public function render()
    {
        return view('livewire.doctor.appointments');
    }
}