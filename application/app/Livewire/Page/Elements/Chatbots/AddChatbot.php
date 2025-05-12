<?php

namespace App\Livewire\Page\Elements\Chatbots;

use Livewire\Component;

class AddChatbot extends Component
{

    public $defaultSettings;

    public function mount()
    {
        $this->defaultSettings = [
            "headline" => __("Chat with our AI"),
            "description" => __("Ask any question and our AI will answer!"),
            "welcome_message" => __("
            Hi there 👋
            I'm the AI Assistant.
    
            How can I help you today?
            "),
            "has_welcome_message_popup" => false,
            "has_collect_name_and_email" => false,
            "brand_color" => "#0092b8",
            "theme" => "dark",
            "orientation" => "right",
            "logo" => null,
            "behavior" => [
                "instructions" => "",
                "conversation_style" => 'Casual',
                "creativity" => 0.7,
            ]
        ];
    }
    public function render()
    {
        return view('livewire.page.elements.chatbots.add-chatbot');
    }
}
