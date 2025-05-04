<?php

namespace App\Livewire\Page\Knowledge;

use App\Models\Embedding;
use App\Models\KnowledgeDocument;
use Flux\Flux;
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
        $this->document->status = 'training';
        $this->document->save();

        // Here you would typically dispatch a job to handle the training
        // For now, we'll just update the status
        $this->document->status = 'trained';
        $this->document->trained_at = now();
        $this->document->save();

        Flux::toast(
            text: 'Document training started',
            variant: 'success'
        );
    }

    public function deleteDocument()
    {
        Storage::disk('public')->delete($this->document->path);
        $this->document->delete();
        Embedding::where('source_id', $this->document->id)
            ->where('source_type', KnowledgeDocument::class)
            ->delete();

        Flux::toast(
            text: 'Document deleted successfully',
            variant: 'success'
        );

        $this->dispatch('document-deleted');
    }
}
