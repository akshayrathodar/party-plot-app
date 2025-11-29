<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function saveLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $login_type => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        if (Auth::attempt($credentials,$request->has('remember_me'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // your intended route
        }

        return back()->with(['error' => 'Invalid login credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
