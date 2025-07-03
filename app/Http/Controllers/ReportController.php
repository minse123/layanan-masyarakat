<?php

namespace App\Http\Controllers;

use App\Models\MasterKonsultasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // Tambahkan ini jika pakai barryvdh/laravel-dompdf

class ReportController extends Controller
{

    private function applyPeriodeFilter($query, $request)
    {
        if ($request->filter == 'harian' && $request->tanggal) {
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
                $q->whereDate('tanggal_pengajuan', $request->tanggal);
            });
        } elseif ($request->filter == 'mingguan' && $request->minggu) {
            [$year, $week] = explode('-W', $request->minggu);
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($year, $week) {
                $q->whereRaw('YEAR(tanggal_pengajuan) = ? AND WEEK(tanggal_pengajuan, 1) = ?', [$year, $week]);
            });
        } elseif ($request->filter == 'bulanan' && $request->bulan) {
            [$year, $month] = explode('-', $request->bulan);
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($year, $month) {
                $q->whereYear('tanggal_pengajuan', $year)->whereMonth('tanggal_pengajuan', $month);
            });
        } elseif ($request->filter == 'tahunan' && $request->tahun) {
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
                $q->whereYear('tanggal_pengajuan', $request->tahun);
            });
        }
    }
    // Report Konsultasi Pelatihan Inti
    public function reportInti(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_inti');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_inti', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        return view('report.konsultasi.inti', compact('data'));
    }

    public function cetakInti(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_inti');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_inti', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        $pdf = PDF::loadView('report.konsultasi.cetakinti', compact('data'));
        return $pdf->stream('laporan_konsultasi_pelatihan_inti.pdf');
    }

    // Report Konsultasi Pelatihan Pendukung
    public function reportPendukung(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_pendukung');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_pendukung', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        return view('report.konsultasi.pendukung', compact('data'));
    }

    public function cetakPendukung(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_pendukung');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_pendukung', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        $pdf = PDF::loadView('report.konsultasi.cetakpendukung', compact('data'));
        return $pdf->stream('laporan_konsultasi_pelatihan_pendukung.pdf');
    }

}