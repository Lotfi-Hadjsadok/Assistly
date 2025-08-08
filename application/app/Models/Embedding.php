<?php

namespace App\Models;

use App\Models\KnowledgeDocument;
use App\Models\KnowledgeWebsite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Embedding extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'source',
        'embedding',
        'metadata',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'metadata' => 'array',
            'embedding' => 'array',
        ];
    }


    public static function getVectorsOfSimilarity($embedding, $chatbot = null)
    {
        $embedding = json_encode($embedding);
        $sub = Embedding::selectRaw('*, embedding <=> ? as distance', [$embedding]);

        // If chatbot is provided, filter by linked knowledge sources
        if ($chatbot) {
            // Get IDs of knowledge sources linked to this chatbot
            $linkedDocumentIds = $chatbot->knowledgeDocuments()->pluck('knowledgeable_id');
            $linkedWebsiteIds = $chatbot->knowledgeWebsites()->pluck('knowledgeable_id');

            $sub->where(function ($query) use ($linkedDocumentIds, $linkedWebsiteIds) {
                $query->where(function ($q) use ($linkedDocumentIds) {
                    $q->where('source_type', KnowledgeDocument::class)
                        ->whereIn('source_id', $linkedDocumentIds);
                })->orWhere(function ($q) use ($linkedWebsiteIds) {
                    $q->where('source_type', KnowledgeWebsite::class)
                        ->whereIn('source_id', $linkedWebsiteIds);
                });
            });
        }

        $vectors = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub->getQuery()) // required to keep bindings
            ->where('distance', '<', 0.88)
            ->orderBy('distance')
            ->limit(10)
            ->get();

        return $vectors;
    }

    public function source()
    {
        return $this->morphTo();
    }
}
