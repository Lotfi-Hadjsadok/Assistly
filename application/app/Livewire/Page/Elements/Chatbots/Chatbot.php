<?php

namespace App\Livewire\Page\Elements\Chatbots;

use App\Services\TrainAIService;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChatbotMessage;
use App\Livewire\Forms\ChatbotForm;
use App\Models\Chatbot as ChatBotModel;
use App\Models\ChatbotSession;
use Illuminate\Support\Facades\Session;

class Chatbot extends Component
{
    public $messages = [];
    public ChatBotModel|ChatbotForm $chatbot;
    public $preview;
    public $height = '100%';
    public $width = '750px';
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
        $this->messages = $session?->messages()->get()->toArray() ?? [];
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
        if ($this->message == '') {
            return;
        }
        $this->message = trim($this->message);
        $session = $this->chatbot->sessions()->firstOrCreate([
            'session_id' => $this->session,
        ]);
        $messageContent = [
            'content' => $this->message,
            'role' => 'user',
        ];
        $this->message = '';
        $message = $session->messages()->create($messageContent);
        $this->messages = array_merge($this->messages, [$messageContent]);
        $this->loading = true;
        $this->dispatch('generate-response', message: $message, session: $session->id);
        $this->dispatch('message-sent');
    }

    #[On('generate-response')]
    public function generateResponse($message, ChatbotSession $session)
    {
        $ai = app(TrainAIService::class);

        if ($this->chatbot->user->credits > 0) {
            $response = 'Answer';
            $this->chatbot->user->decrement('credits', 1);
        } else {
            $response = 'Contact support.';
        }

        $messageContent = [
            'content' => $response,
            'role' => 'assistant'
        ];
        $response = $session->messages()->create($messageContent);
        $this->messages = array_merge($this->messages, [$messageContent]);
        $this->loading = false;
        $this->dispatch('message-sent');
        $this->dispatch('creditsUpdated');
    }

    public function newChat()
    {
        $this->session = uniqid();
        Session::put('session_id', $this->session);
        $this->refreshMessages();
    }


    public function render()
    {
        return view('livewire.page.elements.chatbots.chatbot');
    }
}
