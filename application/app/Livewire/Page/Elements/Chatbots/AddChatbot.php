<?php

namespace App\Livewire\Page\Elements\Chatbots;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddChatbot extends Component
{

    public $settings;
    public $messages = [];

    public $colors = [
        '#1e293b', // slate-800
        '#1f2937', // gray-800
        '#18181b', // zinc-900
        '#171717', // neutral-900
        '#1c1917', // stone-900
        '#7f1d1d', // red-900
        '#7c2d12', // orange-900
        '#78350f', // amber-900
        '#713f12', // yellow-900
        '#365314', // lime-900
        '#14532d', // green-900
        '#064e3b', // emerald-900
        '#164e63', // cyan-900
        '#1e40af', // blue-800
        '#4c1d95', // violet-900
        '#581c87', // purple-900
        '#701a75', // fuchsia-900
        '#831843', // pink-900
        '#881337', // rose-900
    ];





    public function mount()
    {
        $user = Auth::user();
        $this->settings = [
            "headline" => __("Chat with our AI"),
            "description" => __("Ask any question and our AI will answer!"),
            "welcome_message" => __("Hi there 👋 
I'm the AI Assistant.

How can I help you today?"),
            "has_welcome_message_popup" => false,
            "has_collect_name_and_email" => false,
            "brand_color" => "#0092b8",
            "theme" => "light",
            "orientation" => "left",
            "logo" => null,
            "behavior" => [
                "instructions" => "",
                "conversation_style" => 'Casual',
                "creativity" => 0.7,
            ]
        ];


        $this->messages = [
            [
                'role' => 'user',
                'content' => "Hi there 👋 
Am {$user->name}"
            ]
];
    }   
    public function render()
    {
        return view('livewire.page.elements.chatbots.add-chatbot');
    }
}
