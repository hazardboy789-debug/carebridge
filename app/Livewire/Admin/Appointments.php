<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appointment;
use App\Models\User;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Appointments extends Component
{
    use WithPagination;

    public $search = '';
    public $dateRange = 'All';
    public $status = 'All Status';
    public $doctor = null;
    public $type = 'All Types';

    public $doctors = [];
    public $startDate = null;
    public $endDate = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingDoctor()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->doctors = User::whereHas('doctorDetail')->get(['id', 'name']);

        $appointments = Appointment::with(['patient', 'doctor'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('patient', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    })->orWhereHas('doctor', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->status && $this->status !== 'All Status', function($q) {
                $q->where('status', $this->status);
            })
            ->when($this->doctor, function($q) {
                $q->where('doctor_id', $this->doctor);
            })
            ->when($this->type && $this->type !== 'All Types' && \Illuminate\Support\Facades\Schema::hasColumn('appointments', 'type'), function($q) {
                $q->where('type', $this->type);
            })
            ->when($this->dateRange && $this->dateRange !== 'All', function($q) {
                $today = now();
                if ($this->dateRange === 'Today') {
                    $q->whereDate('scheduled_at', $today->format('Y-m-d'));
                } elseif ($this->dateRange === 'This Week') {
                    $q->whereBetween('scheduled_at', [
                        $today->copy()->startOfWeek()->startOfDay(),
                        $today->copy()->endOfWeek()->endOfDay(),
                    ]);
                } elseif ($this->dateRange === 'This Month') {
                    $q->whereBetween('scheduled_at', [
                        $today->copy()->startOfMonth()->startOfDay(),
                        $today->copy()->endOfMonth()->endOfDay(),
                    ]);
                } elseif ($this->dateRange === 'Custom Range') {
                    if ($this->startDate && $this->endDate) {
                        $q->whereBetween('scheduled_at', [
                            \Carbon\Carbon::parse($this->startDate)->startOfDay(),
                            \Carbon\Carbon::parse($this->endDate)->endOfDay(),
                        ]);
                    }
                }
            })
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        // Stats for today
        $today = now()->format('Y-m-d');
        $todayStats = [
            'total' => Appointment::whereDate('scheduled_at', $today)->count(),
            'completed' => Appointment::whereDate('scheduled_at', $today)
                ->where('status', 'completed')->count(),
            'upcoming' => Appointment::whereDate('scheduled_at', $today)
                ->whereIn('status', ['scheduled', 'confirmed'])->count(),
            'cancelled' => Appointment::whereDate('scheduled_at', $today)
                ->where('status', 'cancelled')->count(),
        ];

        // Today's appointments list
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('scheduled_at', $today)
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('livewire.admin.appointments', [
            'appointments' => $appointments,
            'todayStats' => $todayStats,
            'todayAppointments' => $todayAppointments,
        ]);
    }
}