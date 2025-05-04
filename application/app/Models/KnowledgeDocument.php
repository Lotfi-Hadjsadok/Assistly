<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
