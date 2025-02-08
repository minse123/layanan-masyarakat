<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KonsultasiController;
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
    route::post('/admin/surat/hapus/{id}', [SuratController::class, 'delete'])->name('admin.surat.hapus');
    Route::get('/admin/surat/filter', [SuratController::class, 'filterSurat'])->name('admin.surat.filter');


    Route::get('/admin/laporan/surat/proses', [SuratController::class, 'ProsesIndex'])->name('admin.proses.surat');
    Route::get('/admin/laporan/surat/proses/filter', [SuratController::class, 'filterproses'])->name('admin.proses.surat.filter');
    Route::get('/admin/laporan/surat/proses/resetfilter', [SuratController::class, 'resetfilterproses'])->name('admin.proses.surat.resetfilter');

    Route::get('/admin/laporan/surat/terima', [SuratController::class, 'terimaindex'])->name('admin.terima.surat');
    Route::get('/admin/laporan/surat/terima/filter', [SuratController::class, 'filterterima'])->name('admin.terima.surat.filter');
    Route::get('/admin/laporan/surat/terima/resetfilter', [SuratController::class, 'resetfilterterima'])->name('admin.terima.surat.resetfilter');


    // Route::get('/view-pdf', [AdminController::class, 'cetak'])->name('admin.view-pdf');
    Route::get('/admin/konsultasi', [KonsultasiController::class, 'index'])->name('admin.konsultasi.index');
    Route::post('/admin/konsultasi/store', [KonsultasiController::class, 'store'])->name('admin.konsultasi.store');
    Route::get('/admin/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('admin.konsultasi.show');
    Route::put('/admin/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('admin.konsultasi.update'); // Changed to PUT
    Route::delete('/admin/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('admin.konsultasi.destroy'); // Changed to DELETE
    Route::post('/admin/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('admin.konsultasi.answer');
    Route::get('/admin/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('admin.konsultasi.cetak-pdf');
});
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index']);
});
Route::middleware(['auth', 'role:kasubag'])->group(function () {
    Route::get('/kasubag/dashboard', [KasubagController::class, 'index']);
});

Route::middleware(['auth', 'role:admin,kasubag'])->group(function () {
    // Route::get('/user/dashboard', [UserController::class, 'index']);

    Route::get('/report/tamu/cetak-pdf', [CetakPDFController::class, 'tamucetakPDF'])->name('report.tamu.cetak-pdf');

    Route::get('/report/surat/proses/cetak-pdf', [SuratController::class, 'cetakproses'])->name('report.surat.proses.cetak-pdf');
    Route::get('/report/surat/terima/cetak-pdf', [SuratController::class, 'cetakterima'])->name('report.surat.terima.cetak-pdf');

});
