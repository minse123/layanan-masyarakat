<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LandingController::class, 'landing']);
// Route untuk sesi (login dan logout)
Route::get('/login', [SesiController::class, 'index'])->name('login');
Route::post('/login', [SesiController::class, 'login'])->name('login.process');
Route::get('/login-pegawai', [SesiController::class, 'indexPegawai'])->name('login.pegawai');
Route::post('/login-pegawai', [SesiController::class, 'loginPegawai'])->name('login.pegawai.process');
Route::post('/register-process', [SesiController::class, 'simpanRegister'])->name('register.process');
Route::get('/register', [SesiController::class, 'register'])->name('register');
Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
