<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        require __DIR__ . '/../routes/web.php';
        require __DIR__ . '/../routes/console.php';

        // Admin routes
        Route::middleware(['web', 'auth', 'role:admin'])
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));

        // Masyarakat routes
        Route::middleware(['web', 'auth', 'role:masyarakat'])
            ->prefix('masyarakat')
            ->group(base_path('routes/masyarakat.php'));

        // Tambahkan group lain sesuai kebutuhan
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
