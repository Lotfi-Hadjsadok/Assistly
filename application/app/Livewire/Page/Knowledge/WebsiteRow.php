<?php

namespace App\Livewire\Page\Knowledge;

use Livewire\Component;
use App\Models\KnowledgeWebsite;

class WebsiteRow extends Component
{
    public KnowledgeWebsite $website;
    public function render()
    {
        return view('livewire.page.knowledge.website-row');
    }

    public function trainWebsite()
    {
        $this->website->train();

        $this->website->refresh();
    }
}
