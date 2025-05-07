<?php

namespace App\Livewire\Page\Knowledge;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\KnowledgeWebsite;

class WebsiteRow extends Component
{
    public KnowledgeWebsite $website;
    public function render()
    {
        return view('livewire.page.knowledge.website-row');
    }

    #[On('refresh.{website.id}')]
    public function refresh()
    {
        $this->website->refresh();
    }
}
