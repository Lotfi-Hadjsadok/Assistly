<?php

namespace App\Livewire\Page\Elements\Chatbots;

use App\Livewire\Forms\ChatbotForm;
use App\Models\Chatbot as ChatBotModel;
use Livewire\Component;

class Chatbot extends Component
{
    public $messages = [];
    public ChatBotModel|ChatbotForm $chatbot;
    public $preview;
    public $height = '100%';
    public $width = '450px';
    public $size = 'sm';


    public function mount(ChatBotModel|ChatbotForm $chatbot)
    {
        $this->chatbot = $chatbot instanceof ChatbotForm ? $chatbot->chatbot : $chatbot;
    }

    public function render()
    {
        return view('livewire.page.elements.chatbots.chatbot');
    }
}
