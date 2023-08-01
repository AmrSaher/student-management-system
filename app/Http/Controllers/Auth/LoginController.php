<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);
        $remember = $request->input('remember') == 'on';

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors([
                'email' => 'The email or password you entered is invalid'
            ])->onlyInput('email');
        }
    }
}
