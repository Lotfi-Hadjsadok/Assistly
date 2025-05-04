<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


    public static function getVectorsOfSimilarity($embedding)
    {
        $embedding = json_encode($embedding);
        $vectors = self::orderByRaw('embedding <=> ?', [$embedding])->limit(6)->get();
        return $vectors;
    }

    public function source()
    {
        return $this->morphTo();
    }
}
