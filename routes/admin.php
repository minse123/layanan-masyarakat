<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;



Route::get('/auth', [AdminController::class, 'authIndex'])->name('admin.akun');
Route::get('/auth-formTambah', [AdminController::class, 'authTambah'])->name('admin.auth.tambah');
Route::post('/auth-formSimpan', [AdminController::class, 'authSimpan'])->name('admin.auth.simpan');
Route::get('/auth-formEdit/{id}', [AdminController::class, 'authEdit'])->name('admin.auth.edit');
Route::post('/auth/update/{id}', [AdminController::class, 'authUpdate'])->name('admin.auth.update');
Route::post('/auth/hapus', [AdminController::class, 'authHapus'])->name('admin.auth.hapus');

Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

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

Route::get('/laporan/surat/proses', [SuratController::class, 'ProsesIndex'])->name('admin.proses.surat');
Route::get('/laporan/surat/proses/filter', [SuratController::class, 'filterproses'])->name('admin.proses.surat.filter');
Route::get('/laporan/surat/proses/resetfilter', [SuratController::class, 'resetfilterproses'])->name('admin.proses.surat.resetfilter');

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

Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('admin.konsultasi.index');
Route::post('/konsultasi/store', [KonsultasiController::class, 'store'])->name('admin.konsultasi.store');
Route::get('/konsultasi/{id}', [KonsultasiController::class, 'show'])->name('admin.konsultasi.show');
Route::put('/konsultasi/update/{id}', [KonsultasiController::class, 'update'])->name('admin.konsultasi.update'); // Changed to PUT
Route::delete('/konsultasi/destroy/{id}', [KonsultasiController::class, 'destroy'])->name('admin.konsultasi.destroy'); // Changed to DELETE
Route::post('/konsultasi/{id}/answer', [KonsultasiController::class, 'answer'])->name('admin.konsultasi.answer');
Route::get('/konsultasi/filter', [KonsultasiController::class, 'filter'])->name('admin.konsultasi.filter');
Route::get('/konsultasi/resetfilter', [KonsultasiController::class, 'resetfilter'])->name('admin.konsultasi.resetfilter');
Route::get('/konsultasi/cetak-pdf', [KonsultasiController::class, 'cetakPDF'])->name('admin.konsultasi.cetak-pdf');

Route::get('/admin/video', [VideoController::class, 'index'])->name('admin.video.index');
Route::post('/admin/video', [VideoController::class, 'store'])->name('admin.video.store');
// Route::get('/admin/video/{id}/edit', [VideoController::class, 'edit'])->name('admin.video.edit');
Route::put('/admin/video/{id}', [VideoController::class, 'update'])->name('admin.video.update');
Route::delete('/admin/video/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');