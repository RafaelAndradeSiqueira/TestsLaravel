<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $autentication = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if(!$autentication) {
            return redirect()->route('login')->withErrors([
                'email' => 'The provided credentials do not match our records.',
                'password' => 'The provided credentials do not match our records.',
            ]);
        }

        return redirect()->route('home');
    }

    public function destroy(){
        auth()->logout();

        return redirect()->route('home');
    }
}
