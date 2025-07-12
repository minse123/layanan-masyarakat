<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Route::get('/report/tamu/cetak-pdf', [CetakPDFController::class, 'tamucetakPDF'])->name('report.tamu.cetak-pdf');

Route::middleware(['auth', 'role:admin,psm'])->group(function () {
    Route::get('/konsultasi/inti', [ReportController::class, 'reportinti'])->name('konsultasi.inti.report');
    Route::get('/konsultasi/cetakinti', [ReportController::class, 'cetakinti'])->name('report.konsultasi.cetakinti');
    Route::get('/konsultasi/pendukung', [ReportController::class, 'reportpendukung'])->name('konsultasi.pendukung.report');
    Route::get('/konsultasi/pendukung/cetak-pdf', [ReportController::class, 'cetakpendukung'])->name('report.konsultasi.pendukung.cetak-pdf');

    Route::get('/soal-pelatihan/cetak-pdf', [ReportController::class, 'cetakSoalPdf'])->name('soal-pelatihan.cetak-pdf');
    Route::get('/hasil-pelatihan/cetak-pdf', [ReportController::class, 'cetakHasilPdf'])->name('hasil-pelatihan.cetak-pdf');
    Route::get('/rekap-nilai/cetak-pdf', [ReportController::class, 'cetakRekapNilaiPdf'])->name('rekap-nilai.cetak-pdf');
    Route::get('/statistik-tersulit/cetak-pdf', [ReportController::class, 'cetakStatistikTersulitPdf'])->name('statistik-tersulit.cetak-pdf');

    Route::get('soal-pelatihan/cetak-pdf', [ReportController::class, 'cetakSoalPdf'])
        ->name('soal-pelatihan.cetak-pdf');
});

Route::middleware(['auth', 'role:admin,kasubag'])->group(function () {
    Route::get('/report/surat/proses/cetak-pdf', [SuratController::class, 'cetakproses'])->name('report.surat.proses.cetak-pdf');
    Route::get('/report/surat/terima/cetak-pdf', [SuratController::class, 'cetakterima'])->name('report.surat.terima.cetak-pdf');
    Route::get('/report/surat/tolak/cetak-pdf', [SuratController::class, 'cetaktolak'])->name('report.surat.tolak.cetak-pdf');
});

Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    Route::get('/video/print-report', [ReportController::class, 'printVideo'])->name('admin.video.print_report');
});

    
