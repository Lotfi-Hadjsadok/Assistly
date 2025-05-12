<?php

namespace App\Livewire\Page\Elements;

use App\Models\Chatbot;
use Livewire\Component;

class Chatbots extends Component
{
    public $chatbots;
    public $defaultSettings;


    public function mount()
    {
        $this->chatbots = Chatbot::all();
    }
    public function render()
    {
        return view('livewire.page.elements.chatbots');
    }
}
