<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    /** @use HasFactory<\Database\Factories\ChatbotFactory> */
    use HasFactory;
    protected $casts = [
        'settings' => 'array',
    ];


    public function settings($key){
        return $this->settings[$key];
    }
}
