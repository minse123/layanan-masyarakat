<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MasyarakatController;
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
    Route::get('/resetfilter-data', [AdminController::class, 'resetfilterdata'])->name('admin.resetfilter-data');

    Route::get('/admin/report/tamu', [AdminController::class, 'reportdataTamu'])->name('admin.report.tamu');
    Route::get('/admin/report/tamu/filter-data', [AdminController::class, 'reportfilterData'])->name('admin.report.tamu.filter-data');
    Route::get('/admin/report/tamu/resetfilter-data', [AdminController::class, 'reportresetfilterData'])->name('admin.report.tamu.resetfilter-data');
    Route::get('/admin/report/tamu/cetak-pdf', [AdminController::class, 'cetakPDF'])->name('admin.report.tamu.cetak-pdf');

    Route::get('/admin/surat', [SuratController::class, 'Suratindex'])->name('admin.master.surat');
    Route::put('/admin/surat/update/{id}', [SuratController::class, 'MasterUpdate'])->name('admin.master.surat.update');
    Route::post('/admin/surat/store', [SuratController::class, 'store'])->name('admin.surat.store');
    Route::post('/admin/surat/terima/{id}', [SuratController::class, 'terimaSurat'])->name('admin.surat.terima');
    Route::post('/admin/surat/tolak/{id}', [SuratController::class, 'tolakSurat'])->name('admin.surat.tolak');
    route::post('/admin/surat/hapus/{id}', [SuratController::class, 'delete'])->name('admin.surat.hapus');
    Route::get('/admin/surat/filter', [SuratController::class, 'filterSurat'])->name('admin.surat.filter');
    Route::get('/admin/surat/resetfilter', [SuratController::class, 'resetfilterSurat'])->name('admin.surat.resetfilter');


    Route::get('/admin/laporan/surat/proses', [SuratController::class, 'ProsesIndex'])->name('admin.proses.surat');
    Route::get('/admin/laporan/surat/proses/filter', [SuratController::class, 'filterproses'])->name('admin.proses.surat.filter');
    Route::get('/admin/laporan/surat/proses/resetfilter', [SuratController::class, 'resetfilterproses'])->name('admin.proses.surat.resetfilter');

    Route::get('/admin/laporan/surat/terima', [SuratController::class, 'terimaindex'])->name('admin.terima.surat');
    Route::get('/admin/laporan/surat/terima/filter', [SuratController::class, 'filterterima'])->name('admin.terima.surat.filter');
    Route::get('/admin/laporan/surat/terima/resetfilter', [SuratController::class, 'resetfilterterima'])->name('admin.terima.surat.resetfilter');

    Route::get('/admin/laporan/surat/tolak', [SuratController::class, 'tolakindex'])->name('admin.tolak.surat');
    Route::get('/admin/laporan/surat/tolak/filter', [SuratController::class, 'filtertolak'])->name('admin.tolak.surat.filter');
    Route::get('/admin/laporan/surat/tolak/resetfilter', [SuratController::class, 'resetfiltertolak'])->name('admin.tolak.surat.resetfilter');

    Route::get('/admin/laporan/konsultasi/pending', [KonsultasiController::class, 'pendingindex'])->name('admin.konsultasi.pending');
    Route::get('/admin/laporan/konsultasi/pending/filter', [KonsultasiController::class, 'filterpending'])->name('admin.pending.konsultasi.filter');
    Route::get('/admin/laporan/konsultasi/pending/resetfilter', [KonsultasiController::class, 'resetfilterpending'])->name('admin.pending.konsultasi.resetfilter');

    Route::get('/admin/laporan/konsultasi/dijawab', [KonsultasiController::class, 'dijawabindex'])->name('admin.konsultasi.dijawab');
    Route::get('/admin/laporan/konsultasi/dijawab/filter', [KonsultasiController::class, 'filterdijawab'])->name('admin.dijawab.konsultasi.filter');
    Route::get('/admin/laporan/konsultasi/dijawab/resetfilter', [KonsultasiController::class, 'resetfilterdijawab'])->name('admin.dijawab.konsultasi.resetfilter');

    Route::get('/admin/konsultasi', [KonsultasiController::class, 'index'])->name('admin.konsultasi.index');
    Route::post('/admin/konsultasi/store', [KonsultasiController::class, 'store'])->name('admin.konsultasi.store');
    Route::get('/admin/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('admin.konsultasi.show');
    Route::put('/admin/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('admin.konsultasi.update'); // Changed to PUT
    Route::delete('/admin/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('admin.konsultasi.destroy'); // Changed to DELETE
    Route::post('/admin/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('admin.konsultasi.answer');
    Route::get('/admin/konsultasi/filter', [KonsultasiController::class, 'filter'])->name('admin.konsultasi.filter');
    Route::get('/admin/konsultasi/resetfilter', [KonsultasiController::class, 'resetfilter'])->name('admin.konsultasi.resetfilter');
    Route::get('/admin/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('admin.konsultasi.cetak-pdf');

    Route::get('/admin/video', [VideoController::class, 'index'])->name('admin.video.index');
    Route::post('/admin/video', [VideoController::class, 'store'])->name('admin.video.store');
    // Route::get('/admin/video/{id}/edit', [VideoController::class, 'edit'])->name('admin.video.edit');
    Route::put('/admin/video/{id}', [VideoController::class, 'update'])->name('admin.video.update');
    Route::delete('/admin/video/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');
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
    // Route::get('/user/dashboard', [UserController::class, 'index']);

    Route::get('/report/tamu/cetak-pdf', [CetakPDFController::class, 'tamucetakPDF'])->name('report.tamu.cetak-pdf');

    Route::get('/report/surat/proses/cetak-pdf', [SuratController::class, 'cetakproses'])->name('report.surat.proses.cetak-pdf');
    Route::get('/report/surat/terima/cetak-pdf', [SuratController::class, 'cetakterima'])->name('report.surat.terima.cetak-pdf');
    Route::get('/report/surat/tolak/cetak-pdf', [SuratController::class, 'cetaktolak'])->name('report.surat.tolak.cetak-pdf');
    Route::get('/report/konsultasi/pending/cetak-pdf', [KonsultasiController::class, 'cetakpending'])->name('report.konsultasi.pending.cetak-pdf');
    Route::get('/report/konsultasi/dijawab/cetak-pdf', [KonsultasiController::class, 'cetakdijawab'])->name('report.konsultasi.dijawab.cetak-pdf');
});


Route::middleware(['auth', 'role:masyarakat'])->group(function () {
    Route::get('/masyarakat/dashboard', [MasyarakatController::class, 'index'])->name('masyarakat.dashboard');
    Route::get('/video-pelatihan', [MasyarakatController::class, 'semuaVideo'])->name('masyarakat.videopelatihan');
});