<?php

namespace App\Livewire\Page\Elements\Chatbots;

use Flux\Flux;
use App\Models\Chatbot;
use Livewire\Component;
use App\Livewire\Forms\ChatbotForm;

class EditChatbot extends Component
{
    public ChatbotForm $chatbotForm;
    public Chatbot $chatbot;
    public function mount(Chatbot $chatbot)
    {
        $this->chatbotForm->init($chatbot);
        $this->chatbot = $chatbot;
    }

    public function updated()
    {
        Flux::toast(
            text: 'Your chatbot has been updated',
            variant: 'success',
            heading: 'Chatbot updated',
            position: 'bottom center',
        );
        $this->authorize('update', $this->chatbot);
        $this->chatbotForm->update();
    }


    public function render()
    {
        return view('livewire.page.elements.chatbots.edit-chatbot');
    }
}
