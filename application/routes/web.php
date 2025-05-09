<?php

use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Knowledge;
use App\Livewire\Page\Elements;
use App\Livewire\Page\Login;
use App\Livewire\Page\Register;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {
    // Route::get('/', Home\Index::class);
    Route::get('/dashboard', Dashboard\Index::class)->name('dashboard');
    // Knowledge
    Route::get('/knowledge/websites', Knowledge\Websites::class)->name('knowledge.websites');
    Route::get('/knowledge/documents', Knowledge\Documents::class)->name('knowledge.documents');
    // Elements
    Route::get('/elements/chatbots', Elements\Chatbots::class)->name('elements.chatbots');
});


Route::get('/login', Login\Index::class)->name('login');
Route::get('/register', Register\Index::class)->name('register');
