<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('user/landing');
// });
Route::get('/', [LandingController::class, 'landing']);

Route::get('/buku-tamu', [GuestController::class, 'index'])->name('buku-tamu');
Route::post('/buku-tamu', [GuestController::class, 'simpanData'])->name('simpan-tamu');



// Route untuk sesi (login dan logout)
Route::get('/login', [SesiController::class, 'index'])->name('login');
Route::post('/login', [SesiController::class, 'login'])->name('login.process');
Route::post('/register-process', [SesiController::class, 'simpanRegister'])->name('register.process');
Route::get('/register', [SesiController::class, 'register'])->name('register');
Route::post('/logout', [SesiController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/auth', [AdminController::class, 'authIndex'])->name('admin.akun');
    Route::get('/admin/auth-formTambah', [AdminController::class, 'authTambah'])->name('admin.auth.tambah');
    Route::post('/admin/auth-formSimpan', [AdminController::class, 'authSimpan'])->name('admin.auth.simpan');
    Route::get('/admin/auth-formEdit/{id}', [AdminController::class, 'authEdit'])->name('admin.auth.edit');
    Route::post('/admin/auth/update/{id}', [AdminController::class, 'authUpdate'])->name('admin.auth.update');
    Route::post('/admin/auth/hapus', [AdminController::class, 'authHapus'])->name('admin.auth.hapus');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/tamu', [AdminController::class, 'dataTamu'])->name('admin.tamu');
    Route::post('/form-simpan', [AdminController::class, 'simpanData'])->name('admin-simpan-tamu');
    Route::post('/update-data', [AdminController::class, 'updateTamu'])->name('admin-update-data');
    Route::post('/hapus-data', [AdminController::class, 'hapusTamu'])->name('admin-hapus-data');
    Route::get('/filter-data', [AdminController::class, 'filterData'])->name('admin.filter-data');

    Route::get('/admin/report/tamu', [AdminController::class, 'reportdataTamu'])->name('admin.report.tamu');
    Route::get('/admin/report/tamu/filter-data', [AdminController::class, 'reportfilterData'])->name('admin.report.tamu.filter-data');
    Route::get('/admin/report/tamu/cetak-pdf', [AdminController::class, 'cetakPDF'])->name('admin.report.tamu.cetak-pdf');

    Route::get('/admin/surat', [SuratController::class, 'Suratindex'])->name('admin.master.surat');
    Route::put('/admin/surat/update/{id}', [SuratController::class, 'MasterUpdate'])->name('admin.master.surat.update');
    Route::post('/admin/surat/store', [SuratController::class, 'store'])->name('admin.surat.store');
    Route::post('/admin/surat/terima/{id}', [SuratController::class, 'terimaSurat'])->name('admin.surat.terima');
    Route::post('/admin/surat/tolak/{id}', [SuratController::class, 'tolakSurat'])->name('admin.surat.tolak');



    Route::get('/surat-masuk', [SuratController::class, 'Masukindex'])->name('admin.surat-masuk');
    Route::post('/surat-masuk/update', [SuratController::class, 'updateData'])->name('admin.surat-masuk.update');
    Route::post('/surat-masuk/hapus', [SuratController::class, 'hapusData'])->name('admin.surat-masuk.hapus');
    Route::get('/surat-masuk/filter', [SuratController::class, 'filterData'])->name('admin.surat-masuk.filter');
    Route::get('/surat-masuk/cetak-pdf', [SuratController::class, 'cetakPDF'])->name('admin.surat-masuk.cetak-pdf');

    // Route::get('/view-pdf', [AdminController::class, 'cetak'])->name('admin.view-pdf');
});
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index']);
});
Route::middleware(['auth', 'role:kasubag'])->group(function () {
    Route::get('/kasubag/dashboard', [KasubagController::class, 'index']);
});
