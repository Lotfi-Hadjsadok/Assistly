<?php

namespace App\Models;

use App\Models\Embedding;
use App\Enums\KnowledgeStatus;
use App\Services\TrainAIService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KnowledgeDocument extends Model
{
    /** @use HasFactory<\Database\Factories\KnowledgeDocumentFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'status',
        'trained_at',
    ];

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
        $trainAIService->embedDocument($this);
    }

    public function embeddings()
    {
        return $this->morphMany(Embedding::class, 'source');
    }
}
