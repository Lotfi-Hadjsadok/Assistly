<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;

class UserCredits extends Component
{
    protected $listeners = ['creditsUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.components.user-credits');
    }
}