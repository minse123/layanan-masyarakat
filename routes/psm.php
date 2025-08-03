<?php
use App\Http\Controllers\SoalController\KategoriSoalPelatihanController;
use App\Http\Controllers\SoalController\SoalPelatihanController;
use App\Http\Controllers\SoalController\RekapNilaiController;
use App\Http\Controllers\SoalController\StatistikSoalController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\PsmController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'role:psm,admin'])->group(function () {
    Route::get('/dashboard', [PsmController::class, 'index'])->name('dashboard');
    Route::put('/profile', [PsmController::class, 'updateProfile'])->name('profile.update');

    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('admin.konsultasi.index');
    Route::post('/konsultasi/store', [KonsultasiController::class, 'store'])->name('admin.konsultasi.store');
    Route::get('/konsultasi/filter', [KonsultasiController::class, 'filter'])->name('admin.konsultasi.filter');
    Route::get('/konsultasi/resetfilter', [KonsultasiController::class, 'resetfilter'])->name('admin.konsultasi.resetfilter');
    Route::get('/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::put('/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('admin.konsultasi.update');
    Route::delete('/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('admin.konsultasi.destroy');
    Route::post('/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('admin.konsultasi.answer');
    Route::get('/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('konsultasi.cetak-pdf');

    Route::resource('/kategori-soal-pelatihan', KategoriSoalPelatihanController::class)->names('psm.kategori-soal-pelatihan')->except(['create', 'show', 'edit']);
    Route::resource('/soal-pelatihan', SoalPelatihanController::class)->names('psm.soal-pelatihan')->except(['create', 'show', 'edit']);
    Route::post('/soal-pelatihan/import', [SoalPelatihanController::class, 'importSoal'])->name('psm.soal-pelatihan.import');
    Route::get('/soal-pelatihan/export-example', [SoalPelatihanController::class, 'exportSoalExample'])->name('psm.soal-pelatihan.export-example');
    Route::resource('rekap-nilai', RekapNilaiController::class)->names('psm.rekap-nilai')->except(['show']);
    Route::get('soal-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'getByKategori'])->name('psm.soal-pelatihan.by-kategori');
    Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'store'])->name('psm.hasil-pelatihan.store');
    Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'update'])->name('psm.hasil-pelatihan.update');
    Route::get('statistik-soal', [StatistikSoalController::class, 'index'])->name('psm.statistik-soal.index');
});