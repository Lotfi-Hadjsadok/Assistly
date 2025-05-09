<?php

namespace App\Livewire\Page\Login;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{

    public $email;
    public $password;

    public function render()
    {
        return view('livewire.page.login.index')->layout('components.layouts.auth');
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        $this->addError('email', 'Invalid credentials');
    }
}
