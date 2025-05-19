<?php

namespace App\Livewire\Page\Elements;

use App\Models\Chatbot;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\ChatbotForm;
use Illuminate\Support\Facades\Auth;

class Chatbots extends Component
{
    public $chatbots;
    public ChatbotForm $form;
    public $defaultSettings;


    public function newChatbot()
    {
        $bot = $this->form->create();
        $this->redirect(route('elements.chatbots.edit', $bot->id));
    }

    #[On('refresh')]
    public function mount()
    {
        $this->chatbots = Auth::user()->chatbots;
        $this->form->init();
    }
    public function render()
    {
        return view('livewire.page.elements.chatbots');
    }
}
