<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\User;
use App\Models\DoctorDetail;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentReminder;
use App\Notifications\SystemAnnouncement;
use App\Notifications\PatientAppointmentConfirmation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Appointments extends Component
{
    protected $listeners = [
        'appointmentBooked' => 'loadAppointments'
    ];
    public $showBookingModal = false;
    public $selectedDoctorId;
    public $selectedDoctor;
    public $bookingDate;
    public $bookingTime = '09:00';
    public $bookingReason;
    public $fee = 0;
    public $commissionPercent = null; // loaded from config
    
    public $upcomingAppointments = [];
    public $pastAppointments = [];
    public $doctors = [];

    public $patientWalletBalance = 0;

    public function mount()
    {
        $this->loadAppointments();
        $this->loadDoctors();
        $this->loadPatientWalletBalance();
        // Ensure commission percent is available on mount (fallback to config)
        $this->commissionPercent = floatval(config('payments.platform_commission', 0.10));
    }

    public function loadAppointments()
    {
        $patientId = auth()->id();
        
        // Upcoming appointments (today and future)
        $this->upcomingAppointments = Appointment::with(['doctor', 'doctor.doctorDetail'])
            ->where('patient_id', $patientId)
            ->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('id', 'asc') // Remove appointment_time, use id instead
            ->get()
            ->toArray();

        // Past appointments
        $this->pastAppointments = Appointment::with(['doctor', 'doctor.doctorDetail'])
            ->where('patient_id', $patientId)
            ->where('appointment_date', '<', now()->format('Y-m-d'))
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('id', 'desc') // Remove appointment_time, use id instead
            ->get()
            ->toArray();
    }

    public function loadDoctors()
    {
        $this->doctors = User::where('role', 'doctor')
            ->where('is_active', true)
            ->with('doctorDetail')
            ->get();
    }

    public function loadPatientWalletBalance()
    {
        $user = auth()->user();
        if ($user) {
            $wallet = $user->getOrCreateWallet();
            $this->patientWalletBalance = floatval($wallet->balance ?? 0);
        } else {
            $this->patientWalletBalance = 0;
        }
    }

    public function openBooking()
    {
        $this->showBookingModal = true;
        $this->resetBookingForm();
    }

    public function resetBookingForm()
    {
        $this->selectedDoctorId = null;
        $this->selectedDoctor = null;
        $this->bookingDate = null;
        $this->bookingTime = '09:00';
        $this->bookingReason = null;
    }

    public function closeBooking()
    {
        $this->showBookingModal = false;
        $this->resetBookingForm();
    }

    public function updatedSelectedDoctorId($value)
    {
        if ($value) {
            $this->selectedDoctor = User::with('doctorDetail')->find($value);
            // compute fee if available on doctor detail or user
            $this->fee = floatval($this->selectedDoctor->doctorDetail->consultation_fee ?? $this->selectedDoctor->consultation_fee ?? 0);
            // load commission from config if not already set
            $this->commissionPercent = $this->commissionPercent ?? floatval(config('payments.platform_commission', 0.10));
        } else {
            $this->selectedDoctor = null;
            $this->fee = 0;
        }
    }

    public function checkSlotAvailability()
    {
        if (!$this->selectedDoctorId || !$this->bookingDate) {
            return true;
        }

        // Check if the doctor has an appointment on this date and time
        $existingAppointment = Appointment::where('doctor_id', $this->selectedDoctorId)
            ->where('appointment_date', $this->bookingDate)
            ->where('appointment_time', $this->bookingTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        return !$existingAppointment;
    }

    public function bookAppointment()
    {
        $this->validate([
            'selectedDoctorId' => 'required|exists:users,id',
            'bookingDate' => 'required|date|after:today',
            'bookingTime' => 'required',
            'bookingReason' => 'required|string|min:10|max:500',
        ]);

        // Determine doctor's fee (try doctorDetail->fee or fallback to 0)
        $doctor = User::with('doctorDetail')->find($this->selectedDoctorId);
        $fee = 0;
        if ($doctor) {
            // prefer the new consultation_fee on doctorDetail (null-safe), fallback to user-level consultation_fee
            $fee = $doctor->doctorDetail?->consultation_fee ?? $doctor->consultation_fee ?? 0;
        }

        DB::beginTransaction();
        try {
            // create appointment first
            // normalize time to H:i:s to match DB column
            try {
                $timeFormatted = Carbon::createFromFormat('H:i', $this->bookingTime)->format('H:i:s');
            } catch (\Exception $e) {
                // fallback: use raw value
                $timeFormatted = $this->bookingTime;
            }

            // Ensure appointment_time is always provided (DB column is non-nullable)
            $appointmentTimeForDb = $timeFormatted ?? '00:00:00';
            $scheduledAtForDb = null;
            try {
                $scheduledAtForDb = Carbon::parse($this->bookingDate . ' ' . $appointmentTimeForDb)->toDateTimeString();
            } catch (\Exception $e) {
                $scheduledAtForDb = $this->bookingDate . ' ' . $appointmentTimeForDb;
            }

            $appointment = Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $this->selectedDoctorId,
                'scheduled_at' => $scheduledAtForDb,
                'appointment_date' => $this->bookingDate,
                'appointment_time' => $appointmentTimeForDb,
                'status' => 'pending',
                'symptoms' => $this->bookingReason,
                'fee' => $fee,
                'payment_status' => $fee > 0 ? 'pending' : 'paid',
            ]);

            // If there's a fee, deduct from patient wallet but hold payment until appointment is approved
            if ($fee > 0) {
                $patient = auth()->user();
                $patientWallet = $patient->getOrCreateWallet();

                // Ensure sufficient balance
                if ($patientWallet->balance < $fee) {
                    throw new \Exception('Insufficient wallet balance to pay the doctor fee.');
                }

                // Debit patient (full fee) - money is held until approval
                $patientWallet->balance = $patientWallet->balance - $fee;
                $patientWallet->save();

                WalletTransaction::create([
                    'wallet_id' => $patientWallet->id,
                    'type' => 'debit',
                    'amount' => $fee,
                    'description' => 'Appointment booking (held) - Dr. ' . ($doctor->name ?? ''),
                    'status' => 'pending', // Mark as pending until appointment approved
                    'appointment_id' => $appointment->id,
                ]);

                // Payment will be transferred to doctor upon appointment approval
                // Keep payment_status as 'pending' until then
            }

            DB::commit();

            // Send notifications: notify the doctor and admins
            try {

                // Notify doctor (email + database)
                if ($doctor) {
                    Notification::sendNow($doctor, new AppointmentReminder($appointment));
                }

                // Notify patient (email + database)
                $patient = $appointment->patient;
                if ($patient) {
                    Notification::sendNow($patient, new PatientAppointmentConfirmation($appointment));
                }

                // Notify admins (if your app uses a `role` column)
                $admins = User::where('role', 'admin')->get();
                if ($admins->isNotEmpty()) {
                    $adminMessage = "New appointment booked by {$appointment->patient->name} for " . ($appointment->scheduled_at ?? $appointment->appointment_date);
                    Notification::sendNow($admins, new SystemAnnouncement('New Appointment', $adminMessage, url('/admin/notifications')));
                }
            } catch (\Exception $e) {
                // don't fail booking if notifications fail; log optionally
                logger()->error('Failed to send appointment notifications: ' . $e->getMessage());
            }

            session()->flash('booking_success', 'Appointment booked successfully! Waiting for doctor confirmation.');
            $this->closeBooking();
            $this->loadAppointments();
            // Refresh patient wallet balance in component (so UI updates immediately)
            if (method_exists($this, 'loadPatientWalletBalance')) {
                $this->loadPatientWalletBalance();
            }
            // Dispatch a browser event so frontend listeners can react as well
            if (method_exists($this, 'dispatchBrowserEvent')) {
                $this->dispatchBrowserEvent('appointmentBooked', ['appointmentId' => $appointment->id ?? null]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // If appointment was created but we rolled back, ensure it's removed
            if (isset($appointment) && $appointment instanceof Appointment) {
                try { $appointment->delete(); } catch (\Exception $ex) {}
            }
            session()->flash('error', 'Failed to book appointment: ' . $e->getMessage());
        }
    }

    public function cancelAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::where('patient_id', auth()->id())
                ->where('id', $appointmentId)
                ->first();

            if ($appointment && $appointment->status === 'pending') {
                $appointment->update(['status' => 'cancelled']);
                session()->flash('message', 'Appointment cancelled successfully.');
                $this->loadAppointments();
            } else {
                session()->flash('error', 'Cannot cancel this appointment.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to cancel appointment. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.patient.appointments')
            ->layout('components.layouts.patient', ['currentPatient' => auth()->user()]);
    }
}