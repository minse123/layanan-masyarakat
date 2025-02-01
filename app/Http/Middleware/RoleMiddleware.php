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
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Debugging (hapus setelah selesai)
        \Log::info('Role Middleware Triggered', [
            'user_role' => Auth::user()->role ?? null,
            'required_role' => $role
        ]);

        // Periksa apakah user telah login dan memiliki role yang sesuai
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Redirect jika tidak memiliki akses
        return redirect()->route('login')->with('salah', 'Akses ditolak.');
    }
}
