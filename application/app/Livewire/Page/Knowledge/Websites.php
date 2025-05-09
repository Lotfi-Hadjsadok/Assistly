<?php

namespace App\Livewire\Page\Knowledge;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\KnowledgeWebsite;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\WebsiteKnowledgeForm;

class Websites extends Component
{
    public $websites = [];
    public $search = '';
    public $selectedWebsite = null;
    public WebsiteKnowledgeForm $form;


    #[On('setSelectedWebsite')]
    public function openSettings($id)
    {
        $this->selectedWebsite = Auth::user()->websites()->where('id', $id)->first();
        Flux::modal('knowledge-website-settings')->show();
    }

    #[On('refresh')]
    public function mount()
    {
        $this->websites = Auth::user()->websites;
        $this->selectedWebsite = null;
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

    public function addToSiteMap()
    {
        $this->authorize('update', $this->selectedWebsite);
        $this->form->addToSiteMap($this->selectedWebsite);
        $this->dispatch('refresh')->self();
        $this->dispatch('refresh.' . $this->selectedWebsite->id)->to(WebsiteRow::class);
    }

    public function removeFromSiteMap($page)
    {
        $this->authorize('update', $this->selectedWebsite);
        $this->form->removeFromSiteMap($this->selectedWebsite, $page);
        $this->dispatch('refresh')->self();
        $this->dispatch('refresh.' . $this->selectedWebsite->id)->to(WebsiteRow::class);
    }
}
