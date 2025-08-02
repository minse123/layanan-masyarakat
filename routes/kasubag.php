<?php

use App\Http\Controllers\KasubagController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:kasubag'])->group(function () {
    Route::get('/dashboard', [KasubagController::class, 'index'])->name('kasubag.dashboard');
    Route::put('/profile', [KasubagController::class, 'updateProfile'])->name('profile.update');
    Route::get('/surat', [SuratController::class, 'Suratindex'])->name('admin.master.surat');
    Route::put('/surat/update/{id}', [SuratController::class, 'MasterUpdate'])->name('admin.master.surat.update');
    Route::post('/surat/store', [SuratController::class, 'store'])->name('admin.surat.store');
    Route::post('/surat/terima/{id}', [SuratController::class, 'terimaSurat'])->name('admin.surat.terima');
    Route::post('/surat/tolak/{id}', [SuratController::class, 'tolakSurat'])->name('admin.surat.tolak');
    Route::post('/surat/hapus/{id}', [SuratController::class, 'delete'])->name('admin.surat.hapus');
});