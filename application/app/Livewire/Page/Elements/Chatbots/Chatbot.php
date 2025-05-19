<?php

namespace App\Livewire\Page\Elements\Chatbots;

use App\Services\TrainAIService;
use Livewire\Component;
use Livewire\Attributes\On;
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
    public $message;
    public $loading = false;


    #[On('refresh')]
    public function mount(ChatBotModel|ChatbotForm $chatbot)
    {
        $this->chatbot = $chatbot instanceof ChatbotForm ? $chatbot->chatbot : $chatbot;
        $this->refreshMessages();
    }

    #[On('refreshMessages')]
    public function refreshMessages()
    {
        $this->messages = $this->chatbot->messages()->get()->toArray();
        $this->messages = array_merge([
            [
                'content' => $this->chatbot->settings['welcome_message'],
                'role' => 'assistant',
            ]
        ], $this->messages);
    }
    public function sendMessage()
    {
        $session = $this->chatbot->sessions()->firstOrCreate([
            'session_id' => 222,
        ]);
        $message = $session->messages()->create([
            'content' => $this->message,
            'role' => 'user',
        ]);



        $response = $this->generateResponse($message);

        $response = $session->messages()->create([
            'content' => $response,
            'role' => 'assistant'
        ]);
        return $response;
    }


    public function generateResponse(ChatbotMessage $message)
    {
        $ai = app(TrainAIService::class);
        return $ai->ask($message->content);
    }

    public function render()
    {
        return view('livewire.page.elements.chatbots.chatbot');
    }
}
