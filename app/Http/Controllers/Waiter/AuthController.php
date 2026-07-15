<?php

namespace App\Http\Controllers\Waiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('waiter.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (!Auth::user()->isWaiter()) {
                Auth::logout();
                return back()
                    ->withErrors(['email' => 'Accès réservé aux serveurs.'])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('waiter.tables'));
        }

        return back()
            ->withErrors(['email' => 'Identifiants invalides.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('waiter.login');
    }
}
