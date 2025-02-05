<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateSymlinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'symlink:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create symlinks for storage and images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createSymlinks();
        $this->info('Symlinks created successfully.');
    }

    public function createSymlinks()
    {
        // Buat symlink untuk storage
        $publicStoragePath = public_path('storage');
        $appPublicPath = storage_path('app/public');

        if (!File::exists($publicStoragePath)) {
            File::link($appPublicPath, $publicStoragePath);
        }

        // // Buat symlink untuk images (jika ada)
        // $publicImagesPath = public_path('images');
        // $appImagesPath = storage_path('app/images');

        // if (!File::exists($publicImagesPath)) {
        //     File::link($appImagesPath, $publicImagesPath);
        // }
    }
}
