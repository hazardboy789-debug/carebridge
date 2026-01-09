<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.patient')]
class EmergencyAssistance extends Component
{
    public function render()
    {
        return view('livewire.patient.emergency-assistance');
    }
}
