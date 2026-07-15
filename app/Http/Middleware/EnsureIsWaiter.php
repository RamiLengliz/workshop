<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsWaiter
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isWaiter()) {
            Auth::logout();
            return redirect()->route('waiter.login')
                ->withErrors(['email' => 'Accès réservé aux serveurs.']);
        }

        return $next($request);
    }
}
