<?php
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [MasyarakatController::class, 'index'])->name('masyarakat.dashboard');
Route::put('/profile/update', [MasyarakatController::class, 'updateProfile'])->name('profile.update');
Route::get('/video-pelatihan', [MasyarakatController::class, 'semuaVideo'])->name('masyarakat.videopelatihan');
Route::post('/konsultasi/simpan', [MasyarakatController::class, 'simpanKonsultasi'])->name('simpan-konsultasi');

Route::get('/masyarakat/soal/kategori', [MasyarakatController::class, 'kategori'])->name('masyarakat.soal.kategori');
Route::get('/masyarakat/soal/{kategori}', [MasyarakatController::class, 'latihan'])->name('masyarakat.soal.latihan');

Route::post('/masyarakat/soal/jawaban', [MasyarakatController::class, 'storeSoal'])->name('masyarakat.soal.jawab.submit');
Route::get('/soal/hasil', [MasyarakatController::class, 'hasil'])->name('masyarakat.soal.hasil');

Route::get('/jadwal-pelatihan', [MasyarakatController::class, 'jadwalPelatihan'])->name('jadwal-pelatihan');

