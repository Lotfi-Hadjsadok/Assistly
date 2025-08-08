<?php

namespace App\Livewire\Page\Elements\Chatbots;

use Flux\Flux;
use App\Models\Chatbot;
use App\Models\KnowledgeDocument;
use App\Models\KnowledgeWebsite;
use Livewire\Component;
use App\Livewire\Forms\ChatbotForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class EditChatbot extends Component
{
    public ChatbotForm $chatbotForm;
    public Chatbot $chatbot;

    #[On('refresh')]
    public function mount(Chatbot $chatbot)
    {
        $this->chatbotForm->init($chatbot);
        $this->chatbot = $chatbot;
    }

    public function updated()
    {
        Flux::toast(
            text: 'Your chatbot has been updated',
            variant: 'success',
            heading: 'Chatbot updated',
            position: 'bottom center',
        );
        $this->authorize('update', $this->chatbot);
        $this->chatbotForm->update();
    }

    public function linkDocument($documentId)
    {
        $this->authorize('update', $this->chatbot);
        $this->chatbotForm->linkDocument($documentId);
    }

    public function unlinkDocument($documentId)
    {
        $this->authorize('update', $this->chatbot);
        $this->chatbotForm->unlinkDocument($documentId);
    }

    public function linkWebsite($websiteId)
    {
        $this->authorize('update', $this->chatbot);
        $this->chatbotForm->linkWebsite($websiteId);
    }

    public function unlinkWebsite($websiteId)
    {
        $this->authorize('update', $this->chatbot);
        $this->chatbotForm->unlinkWebsite($websiteId);
    }

    #[Computed]
    public function availableDocuments()
    {
        return $this->chatbotForm->getAvailableDocuments();
    }

    #[Computed]
    public function availableWebsites()
    {
        return $this->chatbotForm->getAvailableWebsites();
    }

    public function render()
    {
        return view('livewire.page.elements.chatbots.edit-chatbot');
    }
}
