<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing')]
class DoctorPage extends Component
{
    public function render()
    {
        return view('livewire.landing.doctor-page');
    }
}
