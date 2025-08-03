<?php
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ConfigurationController\VideoController;
use App\Http\Controllers\ConfigurationController\JadwalPelatihanController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:operator,admin'])->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'operatorIndex'])->name('operator.dashboard');
    Route::put('/profile', [OperatorController::class, 'updateProfile'])->name('profile.update');

    Route::get('/video', [VideoController::class, 'index'])->name('admin.video.index');
    Route::post('/video', [VideoController::class, 'store'])->name('admin.video.store');
    Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('admin.video.edit');
    Route::put('/video/{id}', [VideoController::class, 'update'])->name('admin.video.update');
    Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('admin.video.destroy');

    Route::resource('jadwal-pelatihan', JadwalPelatihanController::class)->names('admin.jadwal-pelatihan')->except(['create', 'show', 'edit']);
    Route::delete('jadwal-pelatihan/{id}', [JadwalPelatihanController::class, 'destroy'])->name('admin.jadwal-pelatihan.destroy');
    Route::get('jadwal-pelatihan/cetak_pdf', [JadwalPelatihanController::class, 'cetak_pdf'])->name('admin.jadwal-pelatihan.cetak_pdf');
    Route::get('jadwal-pelatihan/file/{filename}', [JadwalPelatihanController::class, 'showFile'])->where('filename', '.*')->name('admin.jadwal-pelatihan.file');
});