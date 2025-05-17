<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class SessionController extends Controller
{
    public function create()
    {
        return view("auth.login");
    }

    public function store(Request $request)
    {
        //Validate User Attributes
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'password' => 'Sorry, those credentials are incorrect'
            ]);
        }
        // Get the authenticated user
        $user = Auth::user();

        $request->session()->regenerate();
        // Check user's role and redirect
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // default fallback
        return redirect()->route('home');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
