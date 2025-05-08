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

    #[On('setSelectedWebsite')]
    public function setSelectedWebsite($id)
    {
        $this->selectedWebsite = KnowledgeWebsite::find($id);
        Flux::modal('knowledge-website-settings')->show();
    }


    public function addToSiteMap()
    {
        $this->form->addToSiteMap($this->selectedWebsite);
        $this->dispatch('refresh')->self();
        $this->dispatch('refresh.' . $this->selectedWebsite->id)->to(WebsiteRow::class);
    }

    public function removeFromSiteMap($page)
    {
        $this->form->removeFromSiteMap($this->selectedWebsite, $page);
        $this->dispatch('refresh')->self();
        $this->dispatch('refresh.' . $this->selectedWebsite->id)->to(WebsiteRow::class);
    }
}
