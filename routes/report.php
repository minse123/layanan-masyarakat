<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\SuratController;
use Illuminate\Support\Facades\Route;

// Route::get('/report/tamu/cetak-pdf', [CetakPDFController::class, 'tamucetakPDF'])->name('report.tamu.cetak-pdf');

Route::middleware(['auth', 'role:admin,psm'])->group(function () {
    Route::get('/konsultasi/inti', [ReportController::class, 'reportinti'])->name('konsultasi.inti.report');
    Route::get('/konsultasi/cetakinti', [ReportController::class, 'cetakinti'])->name('report.konsultasi.cetakinti');
    Route::get('/konsultasi/pendukung', [ReportController::class, 'reportpendukung'])->name('konsultasi.pendukung.report');
    Route::get('/konsultasi/pendukung/cetak-pdf', [ReportController::class, 'cetakpendukung'])->name('report.konsultasi.pendukung.cetak-pdf');

    Route::get('soal-pelatihan/cetak-pdf', [CetakPDFController::class, 'cetakSoalPdf'])
        ->name('admin.soal-pelatihan.cetak-pdf');
});

Route::middleware(['auth', 'role:admin,kasubag'])->group(function () {
    Route::get('/report/surat/proses/cetak-pdf', [SuratController::class, 'cetakproses'])->name('report.surat.proses.cetak-pdf');
    Route::get('/report/surat/terima/cetak-pdf', [SuratController::class, 'cetakterima'])->name('report.surat.terima.cetak-pdf');
    Route::get('/report/surat/tolak/cetak-pdf', [SuratController::class, 'cetaktolak'])->name('report.surat.tolak.cetak-pdf');
});