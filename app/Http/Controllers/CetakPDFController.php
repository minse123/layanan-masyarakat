<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\MasterKonsultasi; // Model for consultations
use App\Models\KonsultasiPending; // Model for pending consultations
use App\Models\KonsultasiDijawab; // Model for answered consultations
use App\Models\SuratTerima;
use App\Models\SuratProses;
use App\Models\SuratTolak;
use App\Models\MasterSurat;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\KategoriSoalPelatihan;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakPDFController extends Controller
{
    public function tamucetakPDF(Request $request)
    {
        // ... existing code ...
    }

    public function cetakSoalPdf(Request $request)
    {
        $request->validate([
            'kategori_ids' => 'required|array|min:1',
            'kategori_ids.*' => 'exists:kategori_soal_pelatihan,id',
        ]);

        $kategoriWithSoal = KategoriSoalPelatihan::with('soalPelatihan')
            ->whereIn('id', $request->kategori_ids)
            ->get();

        $pdf = Pdf::loadView('admin.soal.cetak.report-soal-pdf', compact('kategoriWithSoal'));
        return $pdf->stream('laporan-soal-pelatihan.pdf');
    }
}