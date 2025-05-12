<?php

namespace App\Livewire\Page\Elements;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\TrainAIService;

class ChatbotsTest extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isTyping = false;
    public function mount()
    {
        $this->messages = [
            ['role' => 'assistant', 'content' => 'Hello! How can I help you today?']
        ];
    }

    public function sendMessage()
    {
        if (empty($this->newMessage)) {
            return;
        }
        $this->isTyping = true;

        // Add user message
        $this->messages[] = [
            'role' => 'user',
            'content' => $this->newMessage
        ];

        $this->dispatch('botThinking', $this->newMessage)->self();

        $this->newMessage = '';
    }

    #[On('botThinking')]
    public function botResponse($message)
    {
        $response = app(TrainAIService::class)->chat($message);
        $this->isTyping = false;
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $response
        ];
    }

    public function render()
    {
        return view('livewire.page.elements.chatbots-test');
    }
}
