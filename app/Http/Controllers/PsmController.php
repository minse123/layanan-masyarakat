<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKonsultasi;
use App\Models\KonsultasiPending;
use App\Models\KonsultasiDijawab;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;


class PsmController extends Controller
{
    public function index()
    {
        $totalKonsultasiPending = KonsultasiPending::count();
        $totalKonsultasiDijawab = KonsultasiDijawab::count();
        return view('psm.dashboard', compact(
            'totalKonsultasiPending',
            'totalKonsultasiDijawab',
        ));
    }

    public function indexkonsultasi()
    {
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])
            ->orderByRaw("CASE WHEN status = 'Pending' THEN 1 ELSE 0 END DESC")
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru jika status sama
            ->get();

        return view('psm.indexkonsultasi', compact('konsultasi'));
    }
    public function konsultasidijawab(Request $request, $id)
    {
        $konsultasi = MasterKonsultasi::findOrFail($id);

        // Validate the request data
        $request->validate([
            'jawaban' => 'required|string',
        ]);

        // Find the consultation in the pending table
        $konsultasiPending = KonsultasiPending::where('id_konsultasi', $id)->firstOrFail();

        // Create a new record in the KonsultasiDijawab table
        KonsultasiDijawab::create([
            'id_konsultasi' => $id,
            'tanggal_dijawab' => now(),
            'jawaban' => $request->jawaban,
        ]);

        MasterKonsultasi::where('id_konsultasi', $id)->update([
            'status' => 'Dijawab',
        ]);
        // Delete the pending consultation
        $konsultasiPending->delete();
        Alert::success('Selamat', 'Konsultasi Berhasil Dijawab');
        return redirect()->route('psm.konsultasi');
    }
    public function filterkonsultasi(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = MasterKonsultasi::query(); // Query dasar

        $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END");

        if ($filter) {
            switch ($filter) {
                case 'harian':
                    if ($tanggal) {
                        $tanggal = Carbon::parse($tanggal);
                        $query->whereDate('created_at', $tanggal);
                    }
                    break;
                case 'mingguan':
                    if ($minggu) {
                        [$year, $week] = explode('-W', $minggu);
                        $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                        $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                        $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    }
                    break;
                case 'bulanan':
                    if ($bulan) {
                        $tanggal = Carbon::parse($bulan);
                        $query->whereMonth('created_at', $tanggal->month)
                            ->whereYear('created_at', $tanggal->year);
                    }
                    break;
                case 'tahunan':
                    if ($tahun) {
                        $query->whereYear('created_at', $tahun);
                    }
                    break;
            }
        }
        $konsultasi = $query->get(); // Data hasil filter
        session([
            'filter' => $filter,
            'tanggal' => $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        $message = '';
        if ($konsultasi->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('psm.indexkonsultasi', compact('konsultasi', 'message'));
    }
    public function resetfilterkonsultasi(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('psm.konsultasi'); // Redirect ke halaman utama laporan
    }

}
