<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah customer sudah login
        if (Auth::guard('customer')->check()) {
            // Jika sudah login, redirect ke home dengan pesan
            return redirect()->route('home')
                ->with('info', 'Anda sudah login sebagai customer');
        }

        // Lanjutkan request jika customer belum login (guest)
        return $next($request);
    }
}