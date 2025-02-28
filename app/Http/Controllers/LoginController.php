<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // public function store(Request $request) {
    //     // $result = User::fin
    //     dd($request->all());
    // }

    public function show()
    {
        return Inertia::render('Cms/Auth/AuthView');
    }
    public function showResetPassword()
    {
        return Inertia::render('Cms/Auth/AuthView');
    }
    public function showForgetPassword()
    {
        return Inertia::render('Cms/Auth/AuthView');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if email exists
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'message' => 'Email address not found.'
            ]);
        }

        // Attempt to authenticate
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'message' => 'Incorrect password.'
            ]);
        }

        $request->session()->regenerate();
        return Inertia::location('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return Inertia::location('/login');
    }
}
