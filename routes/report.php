<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\CetakPDFController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ConfigurationController\VideoController;
use App\Http\Controllers\ConfigurationController\JadwalPelatihanController;
use Illuminate\Support\Facades\Route;

// Route::get('/report/tamu/cetak-pdf', [CetakPDFController::class, 'tamucetakPDF'])->name('report.tamu.cetak-pdf');
Route::middleware(['auth'])->group(function () {
    Route::get('/report/form', [ReportController::class, 'formReport'])->name('report.form');
    Route::post('/report/store', [ReportController::class, 'store'])->name('report.store');
});

Route::middleware(['auth', 'role:admin,psm'])->group(function () {
    Route::get('/konsultasi/inti', [ReportController::class, 'reportinti'])->name('konsultasi.inti.report');
    Route::get('/konsultasi/cetakinti', [ReportController::class, 'cetakinti'])->name('report.konsultasi.cetakinti');
    Route::get('/konsultasi/pendukung', [ReportController::class, 'reportpendukung'])->name('konsultasi.pendukung.report');
    Route::get('/konsultasi/pendukung/cetak-pdf', [ReportController::class, 'cetakpendukung'])->name('report.konsultasi.pendukung.cetak-pdf');

    Route::get('/soal-pelatihan/cetak-pdf', [ReportController::class, 'cetakSoalPdf'])->name('soal-pelatihan.cetak-pdf');
    Route::get('/report-soal-pelatihan', [ReportController::class, 'reportSoal'])->name('report-soal-pelatihan');

    Route::get('/hasil-peserta', [ReportController::class, 'reportHasilPeserta'])->name('report-hasil-peserta');
    Route::get('/hasil-pelatihan/cetak-pdf', [ReportController::class, 'cetakHasilPdf'])->name('hasil-pelatihan.cetak-pdf');
    Route::get('/rekap-nilai', [ReportController::class, 'reportRekapNilai'])->name('report-rekap-nilai');
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
    Route::get('/report-video', [ReportController::class, 'reportVideo'])->name('report.video');

    Route::get('/jadwal-pelatihan/print-report', [ReportController::class, 'printReport'])->name('jadwal-pelatihan.print-report');
    Route::get('report/jadwal-pelatihan', [ReportController::class, 'jadwalPelatihan'])->name('report.jadwal-pelatihan');
    Route::get('jadwal-pelatihan', [ReportController::class, 'reportJadwalPelatihan'])->name('laporan.jadwal-pelatihan');

});


