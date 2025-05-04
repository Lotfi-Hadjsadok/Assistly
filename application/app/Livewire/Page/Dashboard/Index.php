<?php

namespace App\Livewire\Page\Dashboard;

use App\Models\Embedding;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    public function render()
    {
        return view('livewire.page.dashboard.index');
    }

    // public function mount()
    // {

    //     // $this->embed();

    //     $query = "what is the price of confirmix ?";
    //     $response = Http::post('assistly-ai-server:3000/api/v1/get/embedding', [
    //         'query' => $query,
    //     ]);
    //     $embedding = $response->json();
    //     if (!$embedding) {
    //         return;
    //     }
    //     $embeddings = Embedding::orderByRaw('embedding <-> ?', [json_encode($embedding)])
    //         ->limit(6)
    //         ->get();

    //     $vectors = $embeddings->map(function ($embedding) {
    //         return $embedding->content;
    //     });

    //     $response = Http::post('assistly-ai-server:3000/api/v1/get/response', [
    //         'query' => $query,
    //         'vectors' => $vectors,
    //         'language' => 'ar',
    //     ]);
    //     dd($response->json());
    // }

    public function embed()
    {
        $response = Http::post('assistly-ai-server:3000/api/v1/embed', [
            'url' => 'https://confirmix.com',
        ]);
        $vectors = $response->json()['vectors'] ?? [];
        if (empty($vectors)) {
            return;
        }
        foreach ($vectors as $vector) {
            $embedding = new Embedding();
            $embedding->embedding = $vector['embedding'];
            $embedding->content = $vector['content'];
            $embedding->metadata = $vector['metadata'];
            $embedding->source = $vector['source'];
            $embedding->save();
        }
    }
}
