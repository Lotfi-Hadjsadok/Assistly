<?php

namespace App\Livewire\Page\Knowledge;

use App\Models\Embedding;
use Flux\Flux;
use Livewire\Component;
use App\Models\KnowledgeWebsite;
use App\Models\KnowledgeDocument;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Documents extends Component
{
    use WithFileUploads;
    public $documents = [];
    public $search = '';

    // Form fields
    public $url = '';
    public $document;
    public $title = '';
    public $description = '';

    public function mount()
    {
        $this->documents = KnowledgeDocument::all();
    }

    public function render()
    {
        return view('livewire.page.knowledge.documents');
    }

    public function addDocument()
    {
        $this->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt,csv|max:10240', // 10MB max
        ]);

        $path = $this->document->store(path: 'documents');

        KnowledgeDocument::create([
            'path' => $path,
            'file_name' => $this->document->getClientOriginalName(),
        ]);

        // Reset form
        $this->reset(['document']);

        $this->documents = KnowledgeDocument::all();
        Flux::modal('add-document')->close();
    }

    public function resetForm()
    {
        $this->reset(['document']);
    }

    public function deleteDocument($id)
    {
        $document = KnowledgeDocument::find($id);
        if ($document) {
            Storage::disk('local')->delete($document->path);
            $document->embeddings()->delete();
            $document->delete();

            Flux::toast(
                text: 'Document deleted successfully',
                variant: 'success'
            );
        }
        $this->documents = KnowledgeDocument::all();
    }
}
