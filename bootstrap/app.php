<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        then: function () {
            Route::middleware(['web', 'auth'])->group(function () {
                Route::middleware(['role:admin'])
                    ->prefix('admin')
                    ->group(function () {
                        require base_path('routes/admin.php');
                    });

                Route::middleware(['role:masyarakat'])
                    ->prefix('masyarakat')
                    ->group(function () {
                        require base_path('routes/masyarakat.php');
                    });

                Route::prefix('kasubag')
                    ->group(function () {
                        require base_path('routes/kasubag.php');
                    });

                Route::prefix('operator')
                    ->group(function () {
                        require base_path('routes/operator.php');
                    });

                Route::prefix('psm')
                    ->group(function () {
                        require base_path('routes/psm.php');
                    });

                Route::prefix('report')
                    ->group(function () {
                        require base_path('routes/report.php');
                    });
            });
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
