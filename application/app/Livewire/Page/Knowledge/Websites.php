<?php

namespace App\Livewire\Page\Knowledge;

use Flux\Flux;
use Livewire\Component;
use App\Models\Embedding;
use Livewire\Attributes\On;
use App\Models\KnowledgeWebsite;
use Illuminate\Support\Facades\Http;
use App\Livewire\Forms\WebsiteKnowledgeForm;

class Websites extends Component
{
    public $websites = [];
    public $search = '';
    public $selectedWebsite = null;
    public WebsiteKnowledgeForm $form;

    public function openSettings($id)
    {
        $this->selectedWebsite = KnowledgeWebsite::find($id);
        Flux::modal('knowledge-website-settings')->show();
    }

    #[On('refresh')]
    public function mount()
    {
        $this->websites = KnowledgeWebsite::all();
    }

    public function render()
    {
        return view('livewire.page.knowledge.websites');
    }

    public function addWebsite()
    {
        $this->form->addWebsite();
        $this->dispatch('refresh')->self();
    }

    public function deleteWebsite(KnowledgeWebsite $website)
    {
        $this->form->deleteWebsite($website);
        $this->selectedWebsite = null;
        $this->dispatch('refresh')->self();
    }

    public function addToSiteMap(KnowledgeWebsite $website)
    {
        $this->form->addToSiteMap($website);
        $this->dispatch('refresh')->self();
    }

    public function removeFromSiteMap(KnowledgeWebsite $website, $page)
    {
        $this->form->removeFromSiteMap($website, $page);
        $this->dispatch('refresh')->self();
    }

    public function trainWebsite(KnowledgeWebsite $website)
    {
        $this->form->trainWebsite($website);
        $this->dispatch("refresh.{$website->id}")->to(WebsiteRow::class);
    }
}
