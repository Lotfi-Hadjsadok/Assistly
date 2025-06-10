<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function show(User $user, Chatbot $chatbot)
    {
        if ($user->api_key !== $user->api_key) {
            abort(403, 'Unauthorized');
        }

        return view('livewire.page.elements.chatbots.chatbot-embed', [
            'chatbot' => $chatbot,
        ]);
    }
}
