<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.doctor')]

class DoctorDashboard extends Component
{
    public function render()
    {
        return view('livewire.doctor.doctor-dashboard');
    }
}
