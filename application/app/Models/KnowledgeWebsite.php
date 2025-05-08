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
        'sitemap' => 'array',
    ];

    protected $wasTrained;

    public function getSitemapAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getHasToTrainAttribute()
    {
        return $this->status !== KnowledgeStatus::TRAINED
            || collect($this->sitemap)->some(fn($page) => !$page['trained']);
    }

    public function setWasTrainedAttribute($value)
    {
        $this->wasTrained = $value;
    }

    public function getWasTrainedAttribute()
    {
        return $this->wasTrained;
    }


    public function train()
    {
        $this->wasTrained = $this->status == KnowledgeStatus::TRAINED;
        $this->status = KnowledgeStatus::TRAINING;
        $this->save();
        $trainAIService = app(TrainAIService::class);
        $trainAIService->embedWebsite($this);
    }

    public function setTrained()
    {
        $updatedSitemap = collect($this->sitemap)->map(function ($page) {
            return [
                'url' => $page['url'],
                'trained' => true,
            ];
        })->all();

        $this->update([
            'sitemap' => $updatedSitemap,
            'status' => KnowledgeStatus::TRAINED,
            'trained_at' => now(),
        ]);
    }

    public function embeddings()
    {
        return $this->morphMany(Embedding::class, 'source');
    }
}
