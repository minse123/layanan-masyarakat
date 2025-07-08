<?php

use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\PsmController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LandingController::class, 'landing']);

// guest akses
Route::post('/surat', [GuestController::class, 'storeSurat'])->name('simpan-surat');
Route::post('/konsultasi', [GuestController::class, 'storeKonsultasi'])->name('simpan-konsultasi');

// Route untuk sesi (login dan logout)
Route::middleware('web')->group(function () {
    Route::get('/login', [SesiController::class, 'index'])->name('login');
    Route::post('/login', [SesiController::class, 'login'])->name('login.process');
    Route::post('/register-process', [SesiController::class, 'simpanRegister'])->name('register.process');
    Route::get('/register', [SesiController::class, 'register'])->name('register');
    Route::post('/logout', [SesiController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:psm'])->group(function () {
    Route::get('/psm/dashboard', [PsmController::class, 'index']);

    Route::get('/psm/konsultasi', [PsmController::class, 'indexkonsultasi'])->name('psm.konsultasi.index'); // Changed to DELETE
    Route::post('/psm/konsultasi/{id}/answer', [PsmController::class, 'konsultasidijawab'])->name('psm.konsultasi.jawab');
    Route::get('/psm/konsultasi/filter', [PsmController::class, 'filterkonsultasi'])->name('psm.konsultasi.filter');
    Route::get('/psm/konsultasi/resetfilter', [PsmController::class, 'resetfilterkonsultasi'])->name('psm.konsultasi.resetfilter');
});
Route::middleware(['auth', 'role:kasubag'])->group(function () {
    Route::get('/kasubag/dashboard', [KasubagController::class, 'index'])->name('kasubag.dashboard');
    Route::get('/kasubag/surat', [KasubagController::class, 'Suratindex'])->name('kasubag.surat');
    Route::post('/kasubag/surat/terima/{id}', [KasubagController::class, 'terimaSurat'])->name('kasubag.surat.terima');
    Route::post('/kasubag/surat/tolak/{id}', [KasubagController::class, 'tolakSurat'])->name('kasubag.surat.tolak');
    Route::get('/kasubag/surat/filter', [KasubagController::class, 'filtersurat'])->name('kasubag.surat.filter');
    Route::get('/kasubag/surat/resetfilter', [KasubagController::class, 'resetfiltersurat'])->name('kasubag.surat.resetfilter');
    Route::get('/kasubag/laporan/surat/proses', [KasubagController::class, 'ProsesIndex'])->name('kasubag.proses.surat');
    Route::get('/kasubag/laporan/surat/proses/filter', [KasubagController::class, 'filterproses'])->name('kasubag.proses.surat.filter');
    Route::get('/kasubag/laporan/surat/proses/resetfilter', [KasubagController::class, 'resetfilterproses'])->name('kasubag.proses.surat.resetfilter');
    Route::get('/kasubag/laporan/surat/terima', [KasubagController::class, 'terimaindex'])->name('kasubag.terima.surat');
    Route::get('/kasubag/laporan/surat/terima/filter', [KasubagController::class, 'filterterima'])->name('kasubag.terima.surat.filter');
    Route::get('/kasubag/laporan/surat/terima/resetfilter', [KasubagController::class, 'resetfilterterima'])->name('kasubag.terima.surat.resetfilter');
    Route::get('/kasubag/laporan/surat/tolak', [KasubagController::class, 'tolakindex'])->name('kasubag.tolak.surat');
    Route::get('/kasubag/laporan/surat/tolak/filter', [KasubagController::class, 'filtertolak'])->name('kasubag.tolak.surat.filter');
    Route::get('/kasubag/laporan/surat/tolak/resetfilter', [KasubagController::class, 'resetfiltertolak'])->name('kasubag.tolak.surat.resetfilter');
});

Route::middleware(['auth', 'role:admin,kasubag'])->group(function () {
    // Route::get('/report/surat/proses/cetak-pdf', [SuratController::class, 'cetakproses'])->name('report.surat.proses.cetak-pdf');
    // Route::get('/report/surat/terima/cetak-pdf', [SuratController::class, 'cetakterima'])->name('report.surat.terima.cetak-pdf');
    // Route::get('/report/surat/tolak/cetak-pdf', [SuratController::class, 'cetaktolak'])->name('report.surat.tolak.cetak-pdf');
    Route::get('/report/konsultasi/pending/cetak-pdf', [KonsultasiController::class, 'cetakpending'])->name('report.konsultasi.pending.cetak-pdf');
    Route::get('/report/konsultasi/dijawab/cetak-pdf', [KonsultasiController::class, 'cetakdijawab'])->name('report.konsultasi.dijawab.cetak-pdf');
});

