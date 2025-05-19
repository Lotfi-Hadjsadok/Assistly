<?php

namespace App\Models;

use App\Models\ChatbotSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ChatbotMessage;

class Chatbot extends Model
{
    /** @use HasFactory<\Database\Factories\ChatbotFactory> */
    use HasFactory;
    protected $casts = [
        'settings' => 'array',
    ];


    public function settings($key)
    {
        return $this->settings[$key];
    }


    public function session()
    {
        return $this->hasMany(ChatbotSession::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(ChatbotMessage::class, ChatbotSession::class);
    }
}
