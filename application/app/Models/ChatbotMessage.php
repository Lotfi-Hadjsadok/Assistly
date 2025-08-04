<?php

namespace App\Models;

use App\Models\ChatbotSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotMessage extends Model
{
    /** @use HasFactory<\Database\Factories\ChatbotMessageFactory> */
    use HasFactory;

    public function session()
    {
        return $this->belongsTo(ChatbotSession::class, 'chatbot_session_id');
    }

    public function getContentAttribute($value)
    {
        return parseMarkdown($value);
    }
}
