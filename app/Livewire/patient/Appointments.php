<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use App\Models\User;
use App\Models\DoctorDetail;
use Carbon\Carbon;

#[Layout('components.layouts.patient')]
class Appointments extends Component
{
    public $showBookingModal = false;
    public $selectedDoctorId;
    public $selectedDoctor;
    public $bookingDate;
    public $bookingTime = '09:00';
    public $bookingReason;
    
    public $upcomingAppointments = [];
    public $pastAppointments = [];
    public $doctors = [];

    public function mount()
    {
        $this->loadAppointments();
        $this->loadDoctors();
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
        } else {
            $this->selectedDoctor = null;
        }
    }

    public function checkSlotAvailability()
    {
        if (!$this->selectedDoctorId || !$this->bookingDate) {
            return true;
        }

        // Check if the doctor has an appointment on this date
        $existingAppointment = Appointment::where('doctor_id', $this->selectedDoctorId)
            ->where('appointment_date', $this->bookingDate)
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

        try {
            // Create appointment - only use columns that exist
            Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $this->selectedDoctorId,
                'appointment_date' => $this->bookingDate,
                'status' => 'pending',
                'symptoms' => $this->bookingReason,
                'fee' => 0,
                'payment_status' => 'pending',
            ]);

            session()->flash('booking_success', 'Appointment booked successfully! Waiting for doctor confirmation.');
            
            $this->closeBooking();
            $this->loadAppointments();
            
        } catch (\Exception $e) {
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
        return view('livewire.patient.appointments');
    }
}