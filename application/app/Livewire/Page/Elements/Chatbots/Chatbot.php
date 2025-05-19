<?php

namespace App\Livewire\Page\Elements\Chatbots;

use Livewire\Component;
use App\Models\ChatbotMessage;
use App\Livewire\Forms\ChatbotForm;
use App\Models\Chatbot as ChatBotModel;

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
        $this->welcome_message = new ChatbotMessage();
        $this->welcome_message->content = $this->chatbot->settings['welcome_message'];
        $this->welcome_message->role = 'assistant';
        $this->messages = $this->chatbot->messages()->get()->prepend($this->welcome_message);
    }

    public function render()
    {
        return view('livewire.page.elements.chatbots.chatbot');
    }
}
