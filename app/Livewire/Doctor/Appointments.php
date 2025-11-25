<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use Carbon\Carbon;

#[Layout('components.layouts.doctor')]
class Appointments extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $dateFilter = '';
    public $showModal = false;
    public $editingAppointment = null;

    // Tabs filter
    public $filter = 'today';

    // Form fields
    public $patient_id;
    public $appointment_date;
    public $appointment_time;
    public $symptoms;
    public $notes;
    public $fee;
    public $status_edit = 'scheduled';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $appointments = Appointment::with('patient')
            ->where('doctor_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->filter, function ($query) {
                if ($this->filter === 'today') {
                    $query->whereDate('appointment_date', Carbon::today());
                } elseif ($this->filter === 'upcoming') {
                    $query->where('appointment_date', '>', Carbon::today());
                } elseif ($this->filter === 'pending') {
                    $query->where('status', 'pending');
                }
                // 'all' returns all
            })
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        // Appointment stats for sidebar
        $doctorId = auth()->id();
        $appointmentStats = [
            'today' => Appointment::where('doctor_id', $doctorId)->whereDate('appointment_date', Carbon::today())->count(),
            'week' => Appointment::where('doctor_id', $doctorId)->whereBetween('appointment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'pending' => Appointment::where('doctor_id', $doctorId)->where('status', 'pending')->count(),
            'completed' => Appointment::where('doctor_id', $doctorId)->where('status', 'completed')->count(),
        ];

        return view('livewire.doctor.appointments', [
            'appointments' => $appointments,
            'filter' => $this->filter,
            'appointmentStats' => $appointmentStats,
        ]);
    }

    // ... rest of your methods
}