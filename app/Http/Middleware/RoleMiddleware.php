<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek jika user tidak login, biarkan middleware 'auth' yang menanganinya nanti.
        if (!Auth::check()) {
            return redirect('login');
        }

        // Ambil role dari user yang sedang login
        $userRole = $request->user()->role;

        // Cek jika role user ada di dalam daftar role yang diizinkan oleh route
        if (in_array($userRole, $roles)) {
            // Jika diizinkan, lanjutkan ke halaman yang dituju
            return $next($request);
        }

        // Jika tidak diizinkan, redirect ke halaman utama.
        // Anda juga bisa membuat halaman khusus "403 Unauthorized".
        return redirect('/');
    }
}
