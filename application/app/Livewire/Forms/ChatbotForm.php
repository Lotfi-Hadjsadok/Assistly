<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Chatbot;
use App\Models\KnowledgeDocument;
use App\Models\KnowledgeWebsite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

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
        $this->name = $chatbot->name ?? __("Untitled");
        $this->settings = $chatbot->settings ?? [
            "headline" => __("Chat with our AI"),
            "description" => __("Ask any question and our AI will answer!"),
            "welcome_message" => __("Hi there 👋 
I'm the AI Assistant.

How can I help you today?"),
            "brand_color" => "#0092b8",
            "theme" => "light",
            "orientation" => "right",
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
            'slug' => Str::uuid(),
        ]);

        return $bot;
    }

    public function linkDocument($documentId)
    {
        $document = Auth::user()->documents()->findOrFail($documentId);

        // Check if already linked
        $existingLink = $this->chatbot->knowledgeDocuments()->where('knowledgeable_id', $documentId)->first();
        if (!$existingLink) {
            $this->chatbot->knowledgeDocuments()->attach($document);
            $this->chatbot = $this->chatbot->fresh('knowledgeDocuments');
            Flux::toast(
                text: 'Document linked successfully',
                variant: 'success',
                heading: 'Document linked',
                position: 'bottom center',
            );
        }
    }

    public function unlinkDocument($documentId)
    {
        $this->chatbot->knowledgeDocuments()->detach($documentId);

        Flux::toast(
            text: 'Document unlinked successfully',
            variant: 'success',
            heading: 'Document unlinked',
            position: 'bottom center',
        );
    }

    public function linkWebsite($websiteId)
    {
        $website = Auth::user()->websites()->findOrFail($websiteId);

        // Check if already linked
        $existingLink = $this->chatbot->knowledgeWebsites()->where('knowledgeable_id', $websiteId)->first();
        if (!$existingLink) {
            $this->chatbot->knowledgeWebsites()->attach($websiteId);

            Flux::toast(
                text: 'Website linked successfully',
                variant: 'success',
                heading: 'Website linked',
                position: 'bottom center',
            );
        }
    }

    public function unlinkWebsite($websiteId)
    {
        $this->chatbot->knowledgeWebsites()->detach($websiteId);

        Flux::toast(
            text: 'Website unlinked successfully',
            variant: 'success',
            heading: 'Website unlinked',
            position: 'bottom center',
        );
    }

    public function getAvailableDocuments()
    {
        $linkedDocumentIds = $this->chatbot->knowledgeDocuments()->pluck('knowledgeable_id');

        return Auth::user()->documents()
            ->whereNotIn('id', $linkedDocumentIds)
            ->get();
    }

    public function getAvailableWebsites()
    {
        $linkedWebsiteIds = $this->chatbot->knowledgeWebsites()->pluck('knowledgeable_id');

        return Auth::user()->websites()
            ->whereNotIn('id', $linkedWebsiteIds)
            ->get();
    }
}
