<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->createSymlinks();
    }

    public function createSymlinks()
    {
        // Buat symlink untuk storage
        $publicStoragePath = public_path('storage');
        $appPublicPath = storage_path('app/public');

        if (!File::exists($publicStoragePath)) {
            File::link($appPublicPath, $publicStoragePath);
        }

        // Buat symlink untuk images (jika ada)
        // $publicImagesPath = public_path('images');
        // $appImagesPath = storage_path('app/images');

        // if (!File::exists($publicImagesPath)) {
        //     File::link($appImagesPath, $publicImagesPath);
        // }
    }
}
