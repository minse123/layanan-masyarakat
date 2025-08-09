<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfigurationController\JadwalPelatihanController;
use App\Http\Controllers\ConfigurationController\VideoController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\SoalController\KategoriSoalPelatihanController;
use App\Http\Controllers\SoalController\RekapNilaiController;
use App\Http\Controllers\SoalController\SoalPelatihanController;
use App\Http\Controllers\SoalController\StatistikSoalController;
use App\Http\Controllers\SuratController;
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


$registerSoalRoutes = function () {

};

// --- ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/auth', [AdminController::class, 'authIndex'])->name('admin.auth.index');
    Route::get('/auth-formTambah', [AdminController::class, 'authTambah'])->name('admin.auth.tambah');
    Route::post('/auth-formSimpan', [AdminController::class, 'authSimpan'])->name('admin.auth.simpan');
    Route::get('/auth-formEdit/{id}', [AdminController::class, 'authEdit'])->name('admin.auth.edit');
    Route::post('/auth/update/{id}', [AdminController::class, 'authUpdate'])->name('admin.auth.update');
    Route::post('/auth/hapus', [AdminController::class, 'authHapus'])->name('admin.auth.hapus');

    // Verifikasi Masyarakat
    Route::get('/verifikasi-masyarakat', [AdminController::class, 'verifikasiMasyarakatIndex'])->name('admin.verifikasi-masyarakat');
    Route::post('/verifikasi-masyarakat/{id}/verifikasi', [AdminController::class, 'verifikasiMasyarakat'])->name('admin.verifikasi-masyarakat.verifikasi');
    Route::post('/verifikasi-masyarakat/{id}/tolak', [AdminController::class, 'tolakVerifikasiMasyarakat'])->name('admin.verifikasi-masyarakat.tolak');
    Route::put('/verifikasi-masyarakat/{id}/update', [AdminController::class, 'updateVerifikasiMasyarakat'])->name('admin.verifikasi-masyarakat.update');

    //surat
    Route::get('/surat', [SuratController::class, 'Suratindex'])->name('admin.master.surat');
    Route::put('/surat/update/{id}', [SuratController::class, 'MasterUpdate'])->name('admin.master.surat.update');
    Route::post('/surat/store', [SuratController::class, 'store'])->name('admin.surat.store');
    Route::post('/surat/terima/{id}', [SuratController::class, 'terimaSurat'])->name('admin.surat.terima');
    Route::post('/surat/tolak/{id}', [SuratController::class, 'tolakSurat'])->name('admin.surat.tolak');
    Route::post('/surat/hapus/{id}', [SuratController::class, 'delete'])->name('admin.surat.hapus');


    // Konsultasi
    Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::post('/konsultasi/store', [KonsultasiController::class, 'store'])->name('konsultasi.store');
    Route::get('/konsultasi/filter', [KonsultasiController::class, 'filter'])->name('konsultasi.filter');
    Route::get('/konsultasi/resetfilter', [KonsultasiController::class, 'resetfilter'])->name('konsultasi.resetfilter');
    Route::get('/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('konsultasi.show');
    Route::put('/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('konsultasi.update');
    Route::delete('/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('konsultasi.destroy');
    Route::post('/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('konsultasi.answer');
    Route::get('/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('konsultasi.cetak-pdf');

    // Video
    Route::get('/video', [VideoController::class, 'index'])->name('admin.video.index');
    Route::post('/video', [VideoController::class, 'store'])->name('admin.video.store');
    Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('admin.video.edit');
    Route::put('/video/{id}', [VideoController::class, 'update'])->name('admin.video.update');
    Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');

    //jadwal pelatihan
    Route::resource('jadwal-pelatihan', JadwalPelatihanController::class)->names('admin.jadwal-pelatihan')->except(['create', 'show', 'edit']);
    Route::delete('jadwal-pelatihan/{id}', [JadwalPelatihanController::class, 'destroy'])->name('admin.jadwal-pelatihan.destroy');
    Route::get('jadwal-pelatihan/cetak_pdf', [JadwalPelatihanController::class, 'cetak_pdf'])->name('admin.jadwal-pelatihan.cetak_pdf');
    Route::get('jadwal-pelatihan/file/{filename}', [JadwalPelatihanController::class, 'showFile'])->where('filename', '.*')->name('admin.jadwal-pelatihan.file');

    // Soal Pelatihan
    Route::resource('/kategori-soal-pelatihan', KategoriSoalPelatihanController::class)->names('admin.kategori-soal-pelatihan')->except(['create', 'show', 'edit']);
    Route::resource('/soal-pelatihan', SoalPelatihanController::class)->names('admin.soal-pelatihan')->except(['create', 'show', 'edit']);
    Route::post('/soal-pelatihan/import', [SoalPelatihanController::class, 'importSoal'])->name('admin.soal-pelatihan.import');
    Route::get('/soal-pelatihan/export-example', [SoalPelatihanController::class, 'exportSoalExample'])->name('admin.soal-pelatihan.export-example');
    Route::resource('rekap-nilai', RekapNilaiController::class)->names('admin.rekap-nilai')->except(['show']);
    Route::get('soal-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'getByKategori'])->name('admin.soal-pelatihan.by-kategori');
    Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'store'])->name('admin.hasil-pelatihan.store');
    Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'update'])->name('admin.hasil-pelatihan.update');
    Route::get('statistik-soal', [StatistikSoalController::class, 'index'])->name('admin.statistik-soal.index');
});

// --- PSM ---
Route::prefix('psm')->middleware(['auth', 'role:psm'])->name('psm.')->group(function () use ($registerKonsultasiRoutes, $registerSoalRoutes) {

});
