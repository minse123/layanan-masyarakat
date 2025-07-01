<?php
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [MasyarakatController::class, 'index'])->name('masyarakat.dashboard');
Route::put('/profile/update', [MasyarakatController::class, 'updateProfile'])->name('profile.update');
Route::get('/video-pelatihan', [MasyarakatController::class, 'semuaVideo'])->name('masyarakat.videopelatihan');
Route::post('/konsultasi/simpan', [KonsultasiController::class, 'simpanKonsultasi'])->name('simpan-konsultasi');