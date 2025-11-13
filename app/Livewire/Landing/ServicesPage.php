<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing')]
class ServicesPage extends Component
{
    public function render()
    {
        return view('livewire.landing.services-page');
    }
}
