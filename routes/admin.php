<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SoalController\KategoriSoalPelatihanController;
use App\Http\Controllers\SoalController\SoalPelatihanController;
use App\Http\Controllers\SoalController\RekapNilaiController;
use App\Http\Controllers\SoalController\StatistikSoalController;
use App\Http\Controllers\ConfigurationController\JadwalPelatihanController;
use App\Http\Controllers\ConfigurationController\VideoController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\CetakPDFController;



Route::get('/auth', [AdminController::class, 'authIndex'])->name('admin.akun');
Route::get('/auth-formTambah', [AdminController::class, 'authTambah'])->name('admin.auth.tambah');
Route::post('/auth-formSimpan', [AdminController::class, 'authSimpan'])->name('admin.auth.simpan');
Route::get('/auth-formEdit/{id}', [AdminController::class, 'authEdit'])->name('admin.auth.edit');
Route::post('/auth/update/{id}', [AdminController::class, 'authUpdate'])->name('admin.auth.update');
Route::post('/auth/hapus', [AdminController::class, 'authHapus'])->name('admin.auth.hapus');

Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/surat', [SuratController::class, 'Suratindex'])->name('admin.master.surat');
Route::put('/surat/update/{id}', [SuratController::class, 'MasterUpdate'])->name('admin.master.surat.update');
Route::post('/surat/store', [SuratController::class, 'store'])->name('admin.surat.store');
Route::post('/surat/terima/{id}', [SuratController::class, 'terimaSurat'])->name('admin.surat.terima');
Route::post('/surat/tolak/{id}', [SuratController::class, 'tolakSurat'])->name('admin.surat.tolak');
route::post('/surat/hapus/{id}', [SuratController::class, 'delete'])->name('admin.surat.hapus');


Route::get('/laporan/surat/proses', [SuratController::class, 'ProsesIndex'])->name('admin.proses.surat');
Route::get('/laporan/surat/proses/filter', [SuratController::class, 'filterproses'])->name('admin.proses.surat.filter');
Route::get('/laporan/surat/proses/resetfilter', [SuratController::class, 'resetfilterproses'])->name('admin.proses.surat.resetfilter');

Route::get('/admin/laporan/surat/terima', [SuratController::class, 'terimaindex'])->name('admin.terima.surat');
Route::get('/admin/laporan/surat/terima/filter', [SuratController::class, 'filterterima'])->name('admin.terima.surat.filter');
Route::get('/admin/laporan/surat/terima/resetfilter', [SuratController::class, 'resetfilterterima'])->name('admin.terima.surat.resetfilter');

Route::get('/admin/laporan/surat/tolak', [SuratController::class, 'tolakindex'])->name('admin.tolak.surat');
Route::get('/admin/laporan/surat/tolak/filter', [SuratController::class, 'filtertolak'])->name('admin.tolak.surat.filter');
Route::get('/admin/laporan/surat/tolak/resetfilter', [SuratController::class, 'resetfiltertolak'])->name('admin.tolak.surat.resetfilter');

Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('admin.konsultasi.index');
Route::post('/konsultasi/store', [KonsultasiController::class, 'store'])->name('admin.konsultasi.store');
Route::get('/konsultasi/filter', [KonsultasiController::class, 'filter'])->name('admin.konsultasi.filter');
Route::get('/konsultasi/resetfilter', [KonsultasiController::class, 'resetfilter'])->name('admin.konsultasi.resetfilter');
Route::get('/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('admin.konsultasi.show');
Route::put('/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('admin.konsultasi.update'); // Changed to PUT
Route::delete('/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('admin.konsultasi.destroy'); // Changed to DELETE
Route::post('/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('admin.konsultasi.answer');
Route::get('/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('admin.konsultasi.cetak-pdf');

Route::get('/video', [VideoController::class, 'index'])->name('admin.video.index');
Route::post('/video', [VideoController::class, 'store'])->name('admin.video.store');
// Route::get('/admin/video/{id}/edit', [VideoController::class, 'edit'])->name('admin.video.edit');
Route::put('/video/{id}', [VideoController::class, 'update'])->name('admin.video.update');
Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');

Route::resource('/kategori-soal-pelatihan', KategoriSoalPelatihanController::class)
    ->names('admin.kategori-soal-pelatihan')
    ->except(['create', 'show', 'edit']); // karena tambah/edit pakai modal, tidak perlu route create/edit/show

Route::resource('/soal-pelatihan', SoalPelatihanController::class)
    ->names('admin.soal-pelatihan')
    ->except(['create', 'show', 'edit']);

Route::post('/soal-pelatihan/import', [SoalPelatihanController::class, 'importSoal'])->name('admin.soal-pelatihan.import');
Route::get('/soal-pelatihan/export-example', [SoalPelatihanController::class, 'exportSoalExample'])->name('admin.soal-pelatihan.export-example');

// Rekap Nilai Routes
Route::resource('rekap-nilai', RekapNilaiController::class)->names('admin.rekap-nilai')->except(['show']);

// Get soal by kategori for rekap nilai
Route::get('soal-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'getByKategori'])
    ->name('admin.soal-pelatihan.by-kategori');
Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'store'])->name('admin.hasil-pelatihan.store');
Route::post('hasil-pelatihan/by-kategori/{kategori}', [RekapNilaiController::class, 'update'])->name('admin.hasil-pelatihan.update');

// Statistik Soal
Route::get('statistik-soal', [StatistikSoalController::class, 'index'])
    ->name('admin.statistik-soal.index');

Route::resource('jadwal-pelatihan', JadwalPelatihanController::class)->names('admin.jadwal-pelatihan')->except(['create', 'show', 'edit']);
Route::delete('jadwal-pelatihan/{id}', [JadwalPelatihanController::class, 'destroy'])->name('admin.jadwal-pelatihan.destroy');
Route::get('jadwal-pelatihan/cetak_pdf', [JadwalPelatihanController::class, 'cetak_pdf'])->name('admin.jadwal-pelatihan.cetak_pdf');
Route::get('jadwal-pelatihan/file/{filename}', [JadwalPelatihanController::class, 'showFile'])
    ->where('filename', '.*')
    ->name('admin.jadwal-pelatihan.file');





