<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.patient')]
class SymptomChecker extends Component
{
    public function render()
    {
        return view('livewire.patient.symptom-checker');
    }
}
