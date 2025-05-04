<?php

namespace App\Models;

use App\Enums\KnowledgeStatus;
use App\Models\Embedding;
use App\Services\TrainAIService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KnowledgeWebsite extends Model
{
    /** @use HasFactory<\Database\Factories\KnowledgeWebsiteFactory> */
    use HasFactory;

    protected $casts = [
        'trained_at' => 'datetime',
        'status' => KnowledgeStatus::class,
    ];



    public function train()
    {
        $this->update([
            'status' => 'training',
        ]);

        $trainAIService = app(TrainAIService::class);
        $trainAIService->embedWebsite($this);
    }

    public function embeddings()
    {
        return $this->morphMany(Embedding::class, 'source');
    }
}
