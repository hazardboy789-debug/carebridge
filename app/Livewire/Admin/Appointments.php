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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
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
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        // Stats for today
        $today = now()->format('Y-m-d');
        $todayStats = [
            'total' => Appointment::whereDate('appointment_date', $today)->count(),
            'completed' => Appointment::whereDate('appointment_date', $today)
                ->where('status', 'completed')->count(),
            'upcoming' => Appointment::whereDate('appointment_date', $today)
                ->whereIn('status', ['scheduled', 'confirmed'])->count(),
            'cancelled' => Appointment::whereDate('appointment_date', $today)
                ->where('status', 'cancelled')->count(),
        ];

        return view('livewire.admin.appointments', [
            'appointments' => $appointments,
            'todayStats' => $todayStats
        ]);
    }
}