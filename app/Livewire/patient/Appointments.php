<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\User;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.patient')]

class Appointments extends Component
{
    public $upcomingAppointments = [];
    public $pastAppointments = [];
    
    // Booking properties
    public $showBookingModal = false;
    public $selectedDoctorId;
    public $selectedDoctor;
    public $bookingDate;
    public $bookingTime;
    public $bookingReason;
    public $availableSlots = [];
    public $suggestedSymptoms;

    protected $rules = [
        'selectedDoctorId' => 'required|exists:users,id',
        'bookingDate' => 'required|date|after:today',
        'bookingTime' => 'required',
        'bookingReason' => 'required|min:10'
    ];

    protected $listeners = ['bookWithDoctor' => 'openBookingWithDoctor'];

    public function mount()
    {
        $this->loadAppointments();
        $this->generateTimeSlots();
    }

    public function loadAppointments()
{
    $currentDate = now()->format('Y-m-d');
    $currentTime = now()->format('H:i:s');

    // Upcoming appointments
    $this->upcomingAppointments = Appointment::where('patient_id', auth()->id())
        ->where('status', '!=', 'cancelled')
        ->where(function($query) use ($currentDate, $currentTime) {
            $query->where('appointment_date', '>', $currentDate)
                  ->orWhere(function($q) use ($currentDate, $currentTime) {
                      $q->where('appointment_date', $currentDate)
                        ->where('appointment_time', '>=', $currentTime); 
                  });
        })
        ->with(['doctor', 'doctor.doctorDetail'])
        ->orderBy('appointment_date', 'asc')
        ->orderBy('appointment_time', 'asc') //
        ->get()
        ->toArray();

    // Past appointments
    $this->pastAppointments = Appointment::where('patient_id', auth()->id())
        ->where(function($query) use ($currentDate, $currentTime) {
            $query->where('appointment_date', '<', $currentDate)
                  ->orWhere(function($q) use ($currentDate, $currentTime) {
                      $q->where('appointment_date', $currentDate)
                        ->where('appointment_time', '<', $currentTime); 
                  });
        })
        ->with(['doctor', 'doctor.doctorDetail'])
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'desc') 
        ->get()
        ->toArray();
}

    public function openBooking()
    {
        $this->showBookingModal = true;
        $this->reset(['selectedDoctorId', 'selectedDoctor', 'bookingDate', 'bookingTime', 'bookingReason']);
        $this->generateTimeSlots();
    }

    public function openBookingWithDoctor($doctorId, $symptoms = null)
    {
        $this->selectedDoctorId = $doctorId;
        $this->selectedDoctor = User::with('doctorDetail')->find($doctorId);
        $this->suggestedSymptoms = $symptoms;
        $this->bookingReason = $symptoms ? "Symptoms: " . $symptoms : '';
        $this->showBookingModal = true;
        $this->generateTimeSlots();
    }

    public function generateTimeSlots()
    {
        $slots = [];
        $start = strtotime('09:00');
        $end = strtotime('17:00');
        
        while ($start <= $end) {
            $slots[] = date('H:i:s', $start);
            $start += 1800; // 30 minutes
        }
        
        $this->availableSlots = $slots;
    }

    public function checkSlotAvailability()
    {
        if (!$this->selectedDoctorId || !$this->bookingDate || !$this->bookingTime) {
            return true;
        }

        return !Appointment::where('doctor_id', $this->selectedDoctorId)
            ->where('appointment_date', $this->bookingDate)
            ->where('appointment_time', $this->bookingTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    public function bookAppointment()
    {
        $this->validate();

        if (!$this->checkSlotAvailability()) {
            $this->addError('bookingTime', 'This time slot is already booked. Please choose another time.');
            return;
        }

        // Create appointment
        Appointment::create([
            'patient_id' => auth()->id(),
            'doctor_id' => $this->selectedDoctorId,
            'appointment_date' => $this->bookingDate,
            'appointment_time' => $this->bookingTime,
            'status' => 'pending',
            'symptoms' => $this->bookingReason,
            'notes' => 'Booked via patient portal'
        ]);

        $this->resetBooking();
        $this->loadAppointments();
        
        session()->flash('booking_success', 'Appointment booked successfully! Waiting for doctor confirmation.');
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = Appointment::where('patient_id', auth()->id())->find($appointmentId);
        
        if ($appointment && $appointment->status !== 'cancelled') {
            $appointment->update(['status' => 'cancelled']);
            $this->loadAppointments();
            session()->flash('message', 'Appointment cancelled successfully.');
        }
    }

    public function resetBooking()
    {
        $this->showBookingModal = false;
        $this->reset([
            'selectedDoctorId', 
            'selectedDoctor', 
            'bookingDate', 
            'bookingTime', 
            'bookingReason',
            'suggestedSymptoms'
        ]);
    }

    public function render()
    {
        $doctors = User::where('role', 'doctor')
            ->with('doctorDetail')
            ->get();

        return view('livewire.patient.appointments', compact('doctors'));
    }
}