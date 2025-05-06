<?php

namespace App\Services;

use App\Models\Embedding;
use App\Models\KnowledgeWebsite;
use App\Models\KnowledgeDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TrainAIService
{
    public function __construct()
    {
        //
    }

    public function embedWebsite(KnowledgeWebsite $website)
    {
        try {
            $response = Http::post(AI_SERVER_API . '/embed/website', [
                'url' => $website->url,
            ]);
            $vectors = $response->json('data') ?? [];
            if (empty($vectors)) {
                return;
            }
            $embeddings = [];
            foreach ($vectors as $vector) {
                $embedding = new Embedding();
                $embedding->embedding = $vector['embedding'];
                $embedding->content = $vector['content'];
                $embedding->metadata = $vector['metadata'];
                $embeddings[] = $embedding;
            }
            $website->embeddings()->saveMany($embeddings);

            $website->update([
                'status' => 'trained',
                'trained_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error embedding website: ' . $e->getMessage());
            $website->update([
                'status' => 'failed',
            ]);
            return false;
        }
    }

    public function getEmbedding($query)
    {
        try {
            $response = Http::post(AI_SERVER_API . '/get/embedding', [
                'query' => $query,
            ]);
            return $response->json('data');
        } catch (\Exception $e) {
            Log::error('Error getting embedding: ' . $e->getMessage());
            return false;
        }
    }

    public function getVectorsOfSimilarity($query)
    {
        try {
            $vector = $this->getEmbedding($query);

            if (empty($vector)) {
                return [];
            }

            $vectors = Embedding::getVectorsOfSimilarity($vector)->pluck('content')->toArray();
            return $vectors;
        } catch (\Exception $e) {
            Log::error('Error getting vectors of similarity: ' . $e->getMessage());
            return false;
        }
    }

    public function chat($query, $language = 'en')
    {
        try {
            $vectors = $this->getVectorsOfSimilarity($query);
            if (empty($vectors)) {
                return false;
            }
            $response = Http::post(AI_SERVER_API . '/get/response', [
                'query' => $query,
                'vectors' => $vectors,
                'language' => $language,
            ]);
            return $response->json('data');
        } catch (\Exception $e) {
            Log::error('Error getting response: ' . $e->getMessage());
            return false;
        }
    }

    public function embedDocument(KnowledgeDocument $document)
    {
        try {
            $file = Storage::disk('local')->get($document->path);
            $response = Http::attach(
                'file',
                $file,
                $document->file_name
            )->post(AI_SERVER_API . '/embed/document');
            $vectors = $response->json('data') ?? [];
            if (empty($vectors)) {
                return;
            }
            $embeddings = [];
            foreach ($vectors as $vector) {
                $embedding = new Embedding();
                $embedding->embedding = $vector['embedding'];
                $embedding->content = $vector['content'];
                $embedding->metadata = $vector['metadata'];
                $embeddings[] = $embedding;
            }
            $document->embeddings()->saveMany($embeddings);

            $document->update([
                'status' => 'trained',
                'trained_at' => now(),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error embedding document: ' . $e->getMessage());
            $document->update([
                'status' => 'failed',
            ]);
            return false;
        }
    }
}
