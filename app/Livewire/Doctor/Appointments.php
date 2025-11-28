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
                $appointment->update([
                    'status' => 'confirmed',
                    'notes' => $this->appointmentNotes
                ]);
                
                session()->flash('message', 'Appointment approved successfully.');
                $this->closeModal();
                $this->loadAppointments();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to approve appointment.');
        }
    }

    public function rejectAppointment($appointmentId)
    {
        try {
            $appointment = Appointment::where('doctor_id', auth()->id())
                ->where('id', $appointmentId)
                ->first();

            if ($appointment) {
                $appointment->update([
                    'status' => 'cancelled',
                    'notes' => $this->appointmentNotes
                ]);
                
                session()->flash('message', 'Appointment rejected successfully.');
                $this->closeModal();
                $this->loadAppointments();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reject appointment.');
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