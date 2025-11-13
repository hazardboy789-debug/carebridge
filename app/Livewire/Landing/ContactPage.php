<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.landing')]
class ContactPage extends Component
{
    public function render()
    {
        return view('livewire.landing.contact-page');
    }
}
