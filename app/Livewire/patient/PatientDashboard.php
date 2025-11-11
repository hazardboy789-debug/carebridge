<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.patient')]
class PatientDashboard extends Component
{
    public function render()
    {
        return view('livewire.patient.patient-dashboard');
    }
}
