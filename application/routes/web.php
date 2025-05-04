<?php

use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Knowledge;
use App\Livewire\Page\Elements;
use Illuminate\Support\Facades\Route;

// Route::get('/', Home\Index::class);
Route::get('/dashboard', Dashboard\Index::class)->name('dashboard');

// Knowledge
Route::get('/knowledge/websites', Knowledge\Websites::class)->name('knowledge.websites');
Route::get('/knowledge/documents', Knowledge\Documents::class)->name('knowledge.documents');

// Elements
Route::get('/elements/chatbots', Elements\Chatbots::class)->name('elements.chatbots');
