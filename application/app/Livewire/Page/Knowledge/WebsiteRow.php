<?php

namespace App\Livewire\Page\Knowledge;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Enums\KnowledgeStatus;
use App\Models\KnowledgeWebsite;
use App\Livewire\Forms\WebsiteKnowledgeForm;

class WebsiteRow extends Component
{
    public KnowledgeWebsite $website;
    public WebsiteKnowledgeForm $form;

    public function render()
    {
        return view('livewire.page.knowledge.website-row');
    }

    #[On('refresh.{website.id}')]
    public function refresh()
    {
        $this->website->refresh();
    }

    public function openSettings()
    {
        $this->authorize('update', $this->website);
        $this->dispatch('setSelectedWebsite', id: $this->website->id)->to('page.knowledge.websites');
    }

    public function deleteWebsite()
    {
        $this->authorize('delete', $this->website);
        $this->form->deleteWebsite($this->website);
        $this->dispatch('websiteDeleted')->to('page.knowledge.websites');
    }

    public function trainWebsite()
    {
        if (!$this->website->hasToTrain) {
        }
        $this->authorize('update', $this->website);
        $this->form->trainWebsite($this->website);
        $this->dispatch("refresh.{$this->website->id}")->self();
    }
}
