<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuth
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
        // Cek apakah customer sudah login menggunakan guard 'customer'
        if (!Auth::guard('customer')->check()) {
            // Jika request adalah AJAX atau API
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            
            // Redirect ke halaman login dengan pesan error
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini');
        }

        // Ambil customer yang sedang login
        $customer = Auth::guard('customer')->user();
        
        // Cek apakah customer masih aktif
        if (!$customer->is_active) {
            // Logout customer jika tidak aktif
            Auth::guard('customer')->logout();
            
            // Hapus session
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.');
        }

        // Lanjutkan request jika semua validasi berhasil
        return $next($request);
    }
}