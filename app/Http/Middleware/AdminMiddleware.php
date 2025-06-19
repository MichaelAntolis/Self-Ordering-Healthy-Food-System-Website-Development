<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login');
        }

        if (!Auth::guard('customer')->user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak: Hanya untuk admin');
        }

        return $next($request);
    }
}