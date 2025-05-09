<?php

namespace App\Livewire\Page\Knowledge;

use Flux\Flux;
use Livewire\Component;
use App\Models\Embedding;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\KnowledgeWebsite;
use App\Models\KnowledgeDocument;
use Illuminate\Support\Facades\Auth;
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


    #[On('refresh')]
    public function mount()
    {
        $this->documents = Auth::user()->documents;
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

        Auth::user()->documents()->create([
            'path' => $path,
            'file_name' => $this->document->getClientOriginalName(),
        ]);

        // Reset form
        $this->reset(['document']);
        $this->dispatch('refresh')->self();
        Flux::modal('add-document')->close();
    }

    public function resetForm()
    {
        $this->reset(['document']);
    }
}
