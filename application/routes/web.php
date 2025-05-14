<?php

use App\Livewire\Page\Login;
use App\Livewire\Page\Elements;
use App\Livewire\Page\Register;
use App\Livewire\Page\Dashboard;
use App\Livewire\Page\Knowledge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    // Logout
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');


    // Route::get('/', Home\Index::class);
    Route::get('/dashboard', Dashboard\Index::class)->name('dashboard');
    // Knowledge
    Route::get('/knowledge/websites', Knowledge\Websites::class)->name('knowledge.websites');
    Route::get('/knowledge/documents', Knowledge\Documents::class)->name('knowledge.documents');
    // Elements
    Route::get('/elements/chatbots/edit/{chatbot}', Elements\Chatbots\EditChatbot::class)->name('elements.chatbots.edit');
    Route::get('/elements/chatbots', Elements\Chatbots::class)->name('elements.chatbots');
    Route::get('/elements/chatbots/test', Elements\ChatbotsTest::class)->name('elements.chatbots.test');
});


Route::get('/login', Login\Index::class)->name('login');
Route::get('/register', Register\Index::class)->name('register');
