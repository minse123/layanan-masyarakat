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
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade

class CetakPDFController extends Controller
{
    public function tamuCetakPDF(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = Tamu::query();

        if ($filter == 'harian') {
            $query->whereDate('date', $tanggal);
        } elseif ($filter == 'mingguan') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('date', date('m', strtotime($tanggal)))
                ->whereYear('date', date('Y', strtotime($tanggal)));
        } elseif ($filter == 'tahunan') {
            $query->whereYear('date', date('Y', strtotime($tanggal)));
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.tamu.formCetakPDF', compact('data', 'tanggal'));
        // $pdf->setOption('isRemoteEnabled', true);
        return $pdf->stream('data-tamu.pdf');
    }

    public function cetakPDF()
    {
        // Retrieve all consultation data
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])->get();

        // Check if there is data to generate PDF
        if ($konsultasi->isEmpty()) {
            return redirect()->route('admin.konsultasi.index')->with('error', 'Tidak ada data untuk dicetak.');
        }

        // Create PDF
        $pdf = PDF::loadView('admin.konsultasi.pdf', compact('konsultasi'));

        // Set paper size
        $pdf->setPaper('A4', 'landscape');

        // Download PDF
        return $pdf->download('data_konsultasi.pdf');
    }
}