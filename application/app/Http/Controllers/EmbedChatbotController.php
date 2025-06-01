<?php

namespace App\Http\Controllers;

use App\Models\Chatbot;
use Illuminate\Http\Request;

class EmbedChatbotController extends Controller
{
    /**
     * Display the specified embeddable chatbot.
     *
     * @param  \App\Models\Chatbot  $chatbot
     * @return \Illuminate\View\View
     */
    public function show(Chatbot $chatbot)
    {
        // You can eager load relationships if needed, e.g., messages
        // $chatbot->load('messages'); 

        // The chatbot model instance is automatically resolved and injected by Laravel
        // due to route model binding.
        return view('livewire.page.elements.chatbots.chatbot-embed', [
            'chatbot' => $chatbot,
        ]);
    }
}
