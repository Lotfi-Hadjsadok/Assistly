<?php

namespace App\Livewire\Page\Elements\Chatbots;

use App\Services\TrainAIService;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChatbotMessage;
use App\Livewire\Forms\ChatbotForm;
use App\Models\Chatbot as ChatBotModel;
use Illuminate\Support\Facades\Session;

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
    public $session;

    #[On('refresh')]
    public function mount(ChatBotModel|ChatbotForm $chatbot)
    {
        $this->chatbot = $chatbot instanceof ChatbotForm ? $chatbot->chatbot : $chatbot;
        $this->session = Session::get('session_id', uniqid());
        Session::put('session_id', $this->session);
        $this->refreshMessages();
    }

    #[On('refreshMessages')]
    public function refreshMessages()
    {
        $session = $this->chatbot->sessions()->where('session_id', $this->session)->first();
        $this->messages = $session?->messages()->get()->toArray() ?? [
            [
                'content' => 'Hello, am lotfi!',
                'role' => 'user',
            ]
        ];
        $this->messages = array_merge([
            [
                'content' => $this->chatbot->settings['welcome_message'],
                'role' => 'assistant',
            ],
        ], $this->messages);
        $this->dispatch('refreshed-messages');
        return $this->messages;
    }
    public function sendMessage()
    {
        // $session = $this->chatbot->sessions()->firstOrCreate([
        //     'session_id' => $this->session,
        // ]);
        // $message = $session->messages()->create([
        //     'content' => $this->message,
        //     'role' => 'user',
        // ]);


        // if ($this->chatbot->user->credits > 0) {
        //     $response = $this->generateResponse($message);
        //     $this->chatbot->user->decrement('credits', 1);
        // } else {
        //     $response = 'Contact support.';
        // }

        // $response = $session->messages()->create([
        //     'content' => $response,
        //     'role' => 'assistant'
        // ]);

        // return $response;
        $this->messages[] = [
            'content' => $this->message,
            'role' => 'user'
        ];
        $this->message = "";
        sleep(2);
    }

    public function newChat()
    {
        $this->session = uniqid();
        Session::put('session_id', $this->session);
        $this->refreshMessages();
    }


    public function generateResponse(ChatbotMessage $message)
    {
        $ai = app(TrainAIService::class);
        return $ai->ask($message, 'en');
    }

    public function render()
    {
        return view('livewire.page.elements.chatbots.chatbot');
    }
}
