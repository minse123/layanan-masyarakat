<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\ConfigurationController\JadwalPelatihanController;
use App\Http\Controllers\ConfigurationController\VideoController;
use App\Http\Controllers\KasubagController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PsmController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SoalController\KategoriSoalPelatihanController;
use App\Http\Controllers\SoalController\RekapNilaiController;
use App\Http\Controllers\SoalController\SoalPelatihanController;
use App\Http\Controllers\SoalController\StatistikSoalController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\JawabanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Internal Routes
|--------------------------------------------------------------------------
|
| Here is where you can register internal routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group and require authentication.
|
*/

$registerSuratRoutes = function () {
    Route::get('/surat', [SuratController::class, 'Suratindex'])->name('master.surat');
    Route::put('/surat/update/{id}', [SuratController::class, 'MasterUpdate'])->name('master.surat.update');
    Route::post('/surat/store', [SuratController::class, 'store'])->name('surat.store');
    Route::post('/surat/terima/{id}', [SuratController::class, 'terimaSurat'])->name('surat.terima');
    Route::post('/surat/tolak/{id}', [SuratController::class, 'tolakSurat'])->name('surat.tolak');
    Route::post('/surat/hapus/{id}', [SuratController::class, 'delete'])->name('surat.hapus');
};

$registerKonsultasiRoutes = function (bool $isAdmin = false) {
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
    if ($isAdmin) {
        Route::post('/konsultasi/store', [KonsultasiController::class, 'store'])->name('konsultasi.store');
    }
    Route::get('/konsultasi/filter', [KonsultasiController::class, 'filter'])->name('konsultasi.filter');
    Route::get('/konsultasi/resetfilter', [KonsultasiController::class, 'resetfilter'])->name('konsultasi.resetfilter');
    Route::get('/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::put('/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('konsultasi.update');
    if ($isAdmin) {
        Route::delete('/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('konsultasi.destroy');
    }
    Route::post('/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('konsultasi.answer');
    if ($isAdmin) {
        Route::get('/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('konsultasi.cetak-pdf');
    }
};

$registerVideoRoutes = function () {
    Route::get('/video', [VideoController::class, 'index'])->name('video.index');
    Route::post('/video', [VideoController::class, 'store'])->name('video.store');
    Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
};

$registerJadwalPelatihanRoutes = function () {
    Route::resource('jadwal-pelatihan', JadwalPelatihanController::class)->names('jadwal-pelatihan')->except(['create', 'show', 'edit']);
    Route::delete('jadwal-pelatihan/{id}', [JadwalPelatihanController::class, 'destroy'])->name('jadwal-pelatihan.destroy');
    Route::get('jadwal-pelatihan/cetak_pdf', [JadwalPelatihanController::class, 'cetak_pdf'])->name('jadwal-pelatihan.cetak_pdf');
    Route::get('jadwal-pelatihan/file/{filename}', [JadwalPelatihanController::class, 'showFile'])->where('filename', '.*')->name('jadwal-pelatihan.file');
};

$registerSoalRoutes = function () {
    Route::resource('/kategori-soal-pelatihan', KategoriSoalPelatihanController::class)->names('kategori-soal-pelatihan')->except(['create', 'show', 'edit']);
    Route::resource('/soal-pelatihan', SoalPelatihanController::class)->names('soal-pelatihan')->except(['create', 'show', 'edit']);
    Route::post('/soal-pelatihan/import', [SoalPelatihanController::class, 'importSoal'])->name('soal-pelatihan.import');
    Route::get('/soal-pelatihan/export-example', [SoalPelatihanController::class, 'exportSoalExample'])->name('soal-pelatihan.export-example');
    Route::resource('rekap-nilai', RekapNilaiController::class)->names('rekap-nilai')->except(['show']);
    Route::get('soal-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'getByKategori'])->name('soal-pelatihan.by-kategori');
    Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'store'])->name('hasil-pelatihan.store');
    Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'update'])->name('hasil-pelatihan.update');
    Route::get('statistik-soal', [StatistikSoalController::class, 'index'])->name('statistik-soal.index');
};

// --- ADMIN ---
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () use ($registerSuratRoutes, $registerKonsultasiRoutes, $registerVideoRoutes, $registerJadwalPelatihanRoutes, $registerSoalRoutes) {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/auth', [AdminController::class, 'authIndex'])->name('akun');
    Route::get('/auth-formTambah', [AdminController::class, 'authTambah'])->name('auth.tambah');
    Route::post('/auth-formSimpan', [AdminController::class, 'authSimpan'])->name('auth.simpan');
    Route::get('/auth-formEdit/{id}', [AdminController::class, 'authEdit'])->name('auth.edit');
    Route::post('/auth/update/{id}', [AdminController::class, 'authUpdate'])->name('auth.update');
    Route::post('/auth/hapus', [AdminController::class, 'authHapus'])->name('auth.hapus');
    $registerSuratRoutes();
    $registerKonsultasiRoutes(true);
    $registerVideoRoutes();
    $registerJadwalPelatihanRoutes();
    $registerSoalRoutes();
});

// --- KASUBAG ---
Route::prefix('kasubag')->middleware(['auth', 'role:kasubag'])->name('kasubag.')->group(function () use ($registerSuratRoutes) {
    Route::get('/dashboard', [KasubagController::class, 'index'])->name('dashboard');
    Route::put('/profile', [KasubagController::class, 'updateProfile'])->name('profile.update');
    $registerSuratRoutes();
});

// --- OPERATOR ---
Route::prefix('operator')->middleware(['auth', 'role:operator'])->name('operator.')->group(function () use ($registerVideoRoutes, $registerJadwalPelatihanRoutes) {
    Route::get('/dashboard', [OperatorController::class, 'operatorIndex'])->name('dashboard');
    Route::put('/profile', [OperatorController::class, 'updateProfile'])->name('profile.update');
    $registerVideoRoutes();
    $registerJadwalPelatihanRoutes();
});

// --- PSM ---
Route::prefix('psm')->middleware(['auth', 'role:psm'])->name('psm.')->group(function () use ($registerKonsultasiRoutes, $registerSoalRoutes) {
    Route::get('/dashboard', [PsmController::class, 'index'])->name('dashboard');
    Route::put('/profile', [PsmController::class, 'updateProfile'])->name('profile.update');
    $registerKonsultasiRoutes(false);
    $registerSoalRoutes();
});
