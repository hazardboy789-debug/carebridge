<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Appointment;

class Appointments extends Component
{
    public $upcomingAppointments = [];
    public $pastAppointments = [];

    public function mount()
    {
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        // Get current date and time
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
            ->with(['doctor']) // Only load doctor user for now
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
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
            ->with(['doctor']) // Only load doctor user for now
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.patient.appointments');
    }
}