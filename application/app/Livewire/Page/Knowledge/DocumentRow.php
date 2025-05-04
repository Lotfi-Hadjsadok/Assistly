<?php

namespace App\Livewire\Page\Knowledge;

use App\Models\Embedding;
use App\Models\KnowledgeDocument;
use Flux\Flux;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class DocumentRow extends Component
{
    public KnowledgeDocument $document;

    public function mount(KnowledgeDocument $document)
    {
        $this->document = $document;
    }

    public function render()
    {
        return view('livewire.page.knowledge.document-row');
    }

    public function trainDocument()
    {
        $this->document->train();
        $this->document->refresh();
    }
}
