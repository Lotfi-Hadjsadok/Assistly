<?php

namespace App\Services;

use App\Enums\KnowledgeStatus;
use App\Models\Embedding;
use App\Models\KnowledgeWebsite;
use App\Models\KnowledgeDocument;
use App\Models\ChatbotMessage;
use App\Models\Chatbot;
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
            $urls = collect($website->sitemap ?? [])
                ->prepend([
                    'url' => $website->url,
                    'trained' => $website->was_trained,
                ])
                ->map(fn($page) => [
                    'url' => $page['url'],
                    'trained' => $page['trained'],
                ])
                ->filter(fn($page) => !$page['trained'])
                ->pluck('url')
                ->values()
                ->all();

            if (empty($urls)) {
                $website->setTrained();
                return;
            }

            $response = Http::post(AI_SERVER_API . '/embed/website', [
                'urls' => $urls,
                'knowledgeCredits' => $website->user->knowledge_credits,
            ]);
            if ($response->failed() || empty($response->json('vectors'))) {
                if ($website->was_trained) {
                    $website->update([
                        'status' => KnowledgeStatus::TRAINED_PARTIALLY,
                    ]);
                } else {
                    $website->update([
                        'status' => 'failed',
                    ]);
                }
                return [
                    'error' => $response->json('message'),
                ];
            }
            $data = $response->json('data') ?? [];
            $vectors = $data['vectors'] ?? [];
            $leftCredit = $data['leftCredit'] ?? 0;
            if (empty($vectors)) {
                return;
            }

            $embeddings = collect($vectors)->map(function ($vector) use ($website) {
                return new Embedding([
                    'embedding' => $vector['embedding'],
                    'content' => $vector['content'],
                    'metadata' => $vector['metadata'],
                    'user_id' => $website->user_id,
                ]);
            });

            $website->embeddings()->saveMany($embeddings);
            $website->setTrained();
            $website->user->update([
                'knowledge_credits' => $leftCredit,
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

    public function getVectorsOfSimilarity($query, $chatbot = null)
    {
        try {
            $vector = $this->getEmbedding($query);
            if (empty($vector)) {
                return [];
            }
            $vectors = Embedding::getVectorsOfSimilarity($vector, $chatbot)->pluck('content')->toArray();
            return $vectors;
        } catch (\Exception $e) {
            Log::error('Error getting vectors of similarity: ' . $e->getMessage());
            return false;
        }
    }

    public function ask(ChatbotMessage $message, Chatbot $chatbot, $language = 'en')
    {
        try {
            $memory = $message->session->messages()->get()->toArray();
            array_pop($memory);
            $memory = array_map(function ($item) {
                return [
                    'role' => $item['role'],
                    'content' => $item['content'],
                ];
            }, $memory);
            $vectors = $this->getVectorsOfSimilarity($message->content, $chatbot);
            if (empty($vectors)) {
                return false;
            }
            $response = Http::post(AI_SERVER_API . '/get/response', [
                'query' => $message->content,
                'vectors' => $vectors,
                'language' => $language,
                'memory' => $memory,
                'chatbot' => $chatbot,
            ]);
            return $response->json('data');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
            )->post(AI_SERVER_API . '/embed/document', [
                        'knowledgeCredits' => $document->user->knowledge_credits,
                    ]);

            if ($response->failed()) {
                $document->update([
                    'status' => 'failed',
                ]);
                return [
                    'error' => $response->json('message'),
                ];
            }

            $data = $response->json('data') ?? [];
            $vectors = $data['vectors'] ?? [];
            $leftCredit = $data['leftCredit'] ?? 0;
            if (empty($vectors)) {
                return;
            }
            $embeddings = [];
            foreach ($vectors as $vector) {
                $embedding = new Embedding();
                $embedding->embedding = $vector['embedding'];
                $embedding->content = $vector['content'];
                $embedding->metadata = $vector['metadata'];
                $embedding->user_id = $document->user_id;
                $embeddings[] = $embedding;
            }
            $document->embeddings()->saveMany($embeddings);

            $document->update([
                'status' => KnowledgeStatus::TRAINED,
                'trained_at' => now(),
            ]);

            $document->user->update([
                'knowledge_credits' => $leftCredit,
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
