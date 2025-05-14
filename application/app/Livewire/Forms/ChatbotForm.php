<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Chatbot;
use Illuminate\Support\Facades\Auth;

class ChatbotForm extends Form
{
    public ?Chatbot $chatbot;
    public $settings;
    public $name;
    public $description;
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


    public function init(?Chatbot $chatbot = null)
    {
        $user = Auth::user();
        $this->chatbot = $chatbot;
        $this->name =  $chatbot->name ?? __("Untitled");
        $this->settings =  $chatbot->settings ?? [
            "headline" => __("Chat with our AI"),
            "description" => __("Ask any question and our AI will answer!"),
            "welcome_message" => __("Hi there 👋 
I'm the AI Assistant.

How can I help you today?"),
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
            ],
            [
                'role' => 'assistant',
                'content' => "Hi {$user->name} 👋 
How can I help you today?"
            ]
        ];
    }


    public function update()
    {
        $this->chatbot->update([
            'name' => $this->name,
            'settings' => $this->settings,
        ]);
    }


    public function create()
    {
        $bot = Auth::user()->chatbots()->create([
            'name' => $this->name,
            'settings' => $this->settings,
        ]);

        return $bot;
    }
}
