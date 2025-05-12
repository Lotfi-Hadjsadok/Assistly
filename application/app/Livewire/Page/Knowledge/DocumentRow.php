<?php

namespace App\Livewire\Page\Knowledge;

use Flux\Flux;
use Livewire\Component;
use App\Enums\KnowledgeStatus;
use App\Models\KnowledgeDocument;
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
        $this->authorize('update', $this->document);
        if ($this->document->status == KnowledgeStatus::TRAINING) {
            return;
        }
        $this->document->train();
        $this->document->refresh();
    }

    public function deleteDocument()
    {
        $this->authorize('delete', $this->document);
        Storage::disk('local')->delete($this->document->path);
        $this->document->embeddings()->delete();
        $this->document->delete();

        Flux::toast(
            text: 'Document deleted successfully',
            variant: 'success'
        );
        $this->dispatch('refresh')->to('page.knowledge.documents');
    }
}
