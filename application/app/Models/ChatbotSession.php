<?php

namespace App\Models;

use App\Models\ChatbotMessage;
use Illuminate\Database\Eloquent\Model;

class ChatbotSession extends Model
{

    public function messages()
    {
        return $this->hasMany(ChatbotMessage::class);
    }
}
