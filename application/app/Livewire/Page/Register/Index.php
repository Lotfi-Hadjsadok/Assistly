<?php

namespace App\Livewire\Page\Register;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.page.register.index')->layout('components.layouts.auth');
    }
}
