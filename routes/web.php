<?php

use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\PsmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LandingController::class, 'landing']);
// guest akses
Route::post('/surat', [GuestController::class, 'storeSurat'])->name('simpan-surat');
Route::post('/konsultasi', [GuestController::class, 'storeKonsultasi'])->name('simpan-konsultasi');

// Route untuk sesi (login dan logout)
Route::get('/login', [SesiController::class, 'index'])->name('login');
Route::post('/login', [SesiController::class, 'login'])->name('login.process');
Route::get('/login-pegawai', [SesiController::class, 'indexPegawai'])->name('login.pegawai');
Route::post('/login-pegawai', [SesiController::class, 'loginPegawai'])->name('login.pegawai.process');
Route::post('/register-process', [SesiController::class, 'simpanRegister'])->name('register.process');
Route::get('/register', [SesiController::class, 'register'])->name('register');
Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
