<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Appointment;

#[Layout('components.layouts.doctor')]
class Patients extends Component
{
    use WithPagination;

    public $search = '';
    public $viewModal = false;
    public $viewingPatient = null;
    public $patientAppointments = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $patients = User::whereHas('patientAppointments', function ($query) {
                $query->where('doctor_id', auth()->id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('contact', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount(['patientAppointments as appointment_count' => function ($query) {
                $query->where('doctor_id', auth()->id());
            }])
            ->with(['userDetails'])
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.doctor.patients', [
            'patients' => $patients,
            'patientStats' => $this->getPatientStats(),
        ]);
    }

    public function viewPatient($patientId)
    {
        $this->viewingPatient = User::with('userDetails')->find($patientId);
        
        if ($this->viewingPatient) {
            $this->patientAppointments = Appointment::with('patient')
                ->where('doctor_id', auth()->id())
                ->where('patient_id', $patientId)
                ->orderBy('appointment_date', 'desc')
                ->take(10)
                ->get();
            
            $this->viewModal = true;
        }
    }

    public function closeViewModal()
    {
        $this->viewModal = false;
        $this->viewingPatient = null;
        $this->patientAppointments = [];
    }

    public function getPatientStats()
    {
        $doctorId = auth()->id();
        
        return [
            'total' => User::whereHas('patientAppointments', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })->count(),
            'active_month' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', '>=', now()->subMonth())
                ->distinct('patient_id')
                ->count('patient_id'),
            'new_week' => User::whereHas('patientAppointments', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId)
                      ->whereBetween('created_at', [now()->subWeek(), now()]);
            })->count(),
            'follow_ups' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', '>=', now())
                ->count(),
        ];
    }
}