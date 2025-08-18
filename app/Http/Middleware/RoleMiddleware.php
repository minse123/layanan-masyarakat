<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Debugging (hapus setelah selesai)
        \Log::info('Role Middleware Triggered', [
            'user_role' => Auth::check() ? Auth::user()->role : 'Guest',
            'allowed_roles' => $roles
        ]);

        // Periksa apakah user telah login dan memiliki salah satu role yang sesuai
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Jika user sudah login tapi rolenya tidak sesuai, redirect ke dashboard masing-masing
        if (Auth::check()) {
            $role = Auth::user()->role;
            $dashboardRoute = $role . '.dashboard';

            // Cek apakah route untuk dashboard user tersebut ada
            if (\Illuminate\Support\Facades\Route::has($dashboardRoute)) {
                return redirect()->route($dashboardRoute)->with('error', 'Anda tidak memiliki hak untuk mengakses halaman tersebut.');
            }
        }

        // Jika user belum login atau tidak ada route dashboard yang sesuai, redirect ke halaman login
        alert()->success('', '');
        return redirect()->route('login')->with('salah', 'Akses ditolak. Silakan login terlebih dahulu.');
    }
}
