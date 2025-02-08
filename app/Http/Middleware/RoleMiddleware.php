<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Debugging (hapus setelah selesai)
        \Log::info('Role Middleware Triggered', [
            'user_role' => Auth::user()->role ?? null,
            'allowed_roles' => $roles
        ]);

        // Periksa apakah user telah login dan memiliki salah satu role yang sesuai
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Redirect jika tidak memiliki akses
        return redirect()->route('login')->with('salah', 'Akses ditolak.');
    }
}
