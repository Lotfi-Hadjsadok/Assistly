<?php

namespace App\Models;

use App\Models\User;
use App\Models\ChatbotMessage;
use App\Models\ChatbotSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    public function sessions()
    {
        return $this->hasMany(ChatbotSession::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(ChatbotMessage::class, ChatbotSession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
