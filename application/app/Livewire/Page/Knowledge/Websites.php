<?php

namespace App\Livewire\Page\Knowledge;

use App\Models\Embedding;
use Flux\Flux;
use Livewire\Component;
use App\Models\KnowledgeWebsite;

class Websites extends Component
{
    public $websites = [];
    public $search = '';

    // Form fields
    public $url = '';
    public $title = '';
    public $description = '';

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
        $this->validate([
            'url' => [
                'required',
                'regex:/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}(\/[\w\-\/]*)?$/i',
                'unique:knowledge_websites,url',
            ],
        ]);

        $this->url = "https://{$this->url}";
        KnowledgeWebsite::create([
            'url' => $this->url,
        ]);

        // Reset form
        $this->reset(['url']);

        $this->websites = KnowledgeWebsite::all();
        Flux::modal('add-website')->close();
    }

    public function resetForm()
    {
        $this->reset(['url']);
    }

    public function deleteWebsite($id)
    {
        $website = KnowledgeWebsite::find($id);
        if ($website) {
            $website->embeddings()->delete();
            $website->delete();

            Flux::toast(
                text: 'Website deleted successfully',
                variant: 'success'
            );
        }
        $this->websites = KnowledgeWebsite::all();
    }
}
