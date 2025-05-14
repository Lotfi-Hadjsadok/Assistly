<?php

namespace App\Livewire\Page\Elements;

use Livewire\Component;

class ChatbotRow extends Component
{
    public $chatbot;
    
    public function mount($chatbot)
    {
        $this->chatbot = $chatbot;
    }
    
    public function render()
    {
        return view('livewire.page.elements.chatbot-row');
    }


    public function deleteChatbot()
    {
        $this->chatbot->delete();
        $this->dispatch('refresh')->to(Chatbots::class);
    }
}
