<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\KonsultasiPending;
use App\Models\KonsultasiDijawab;
use App\Models\SuratProses;
use App\Models\SuratTerima;
use App\Models\SuratTolak;
use App\Models\MasterSurat;
use App\Models\MasterKonsultasi;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade

class KasubagController extends Controller
{
    public function index()
    {
        $totalTamu = Tamu::count();
        $totalKonsultasiPending = KonsultasiPending::count();
        $totalKonsultasiDijawab = KonsultasiDijawab::count();
        $totalSuratProses = SuratProses::count();
        $totalSuratTerima = SuratTerima::count();
        $totalSuratTolak = SuratTolak::count();

        return view('kasubag.dashboard', compact(
            'totalTamu',
            'totalKonsultasiPending',
            'totalKonsultasiDijawab',
            'totalSuratProses',
            'totalSuratTerima',
            'totalSuratTolak'
        ));
    }

    public function datatamu()
    {
        $data = Tamu::all();
        return view('kasubag/indextamu', compact('data'));
    }
    public function filterdatatamu(Request $request)
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

        session(['filter' => $filter, 'tanggal' => $tanggal]);

        return view('kasubag/indextamu', compact('data'));
    }
    public function filterresetdatatamu(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('kasubag.tamu'); // Redirect ke halaman utama laporan
    }

    public function tamuindex()
    {
        $data = Tamu::all();
        return view('kasubag/reporttamu', compact('data'));
    }
    public function filtertamu(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = Tamu::query(); // Query dasar

        if ($filter) {
            switch ($filter) {
                case 'harian':
                    if ($tanggal) {
                        $tanggal = Carbon::parse($tanggal);
                        $query->whereDate('date', $tanggal);
                    }
                    break;
                case 'mingguan':
                    if ($minggu) {
                        [$year, $week] = explode('-W', $minggu);
                        $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                        $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                        $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
                    }
                    break;
                case 'bulanan':
                    if ($bulan) {
                        $tanggal = Carbon::parse($bulan);
                        $query->whereMonth('date', $tanggal->month)
                            ->whereYear('date', $tanggal->year);
                    }
                    break;
                case 'tahunan':
                    if ($tahun) {
                        $query->whereYear('date', $tahun);
                    }
                    break;
            }
        }
        $data = $query->get();
        session([
            'filter' => $filter,
            'tanggal' => $tanggal ? $tanggal->toDateString() : null,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('kasubag/reporttamu', compact('data', 'message'));
    }
    public function resetfiltertamu(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('kasubag.report.tamu'); // Redirect ke halaman utama laporan
    }

    public function ProsesIndex()
    {
        $data = SuratProses::with('masterSurat')->get();
        return view('kasubag.reportproses', compact('data')); // Pass the required data to the view
    }
    public function filterproses(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $query = SuratProses::query()->with('masterSurat');
        if ($filter) {
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal, $minggu, $bulan, $tahun) {
                switch ($filter) {
                    case 'harian':
                        if ($tanggal) {
                            $tanggal = Carbon::parse($tanggal);
                            $q->whereDate('tanggal_proses', $tanggal);
                        }
                        break;
                    case 'mingguan':
                        if ($minggu) {
                            [$year, $week] = explode('-W', $minggu);
                            $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                            $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                            $q->whereBetween('tanggal_proses', [$startOfWeek, $endOfWeek]);
                        }
                    case 'bulanan':
                        if ($bulan) {
                            $tanggal = Carbon::parse($bulan);
                            $q->whereMonth('tanggal_proses', $tanggal->month)
                                ->whereYear('tanggal_proses', $tanggal->year);
                        }
                        break;
                    case 'tahunan':
                        if ($tahun) {
                            $q->whereYear('tanggal_proses', $tahun);
                        }
                        break;
                }
            });
        }
        $data = $query->get();
        session([
            'filter' => $filter,
            'tanggal' => $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('kasubag.reportproses', compact('data', 'message'));
    }
    public function resetfilterproses(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('kasubag.proses.surat'); // Redirect ke halaman utama laporan
    }

    public function terimaindex()
    {
        $data = SuratTerima::with('masterSurat')->get();
        return view('kasubag.reportterima', compact('data')); // Pass the required data to the new view
    }
    public function filterterima(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $query = SuratTerima::query()->with('masterSurat');
        if ($filter) {
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal, $minggu, $bulan, $tahun) {
                switch ($filter) {
                    case 'harian':
                        if ($tanggal) {
                            $tanggal = Carbon::parse($tanggal);
                            $q->whereDate('tanggal_terima', $tanggal);
                        }
                        break;
                    case 'mingguan':
                        if ($minggu) {
                            [$year, $week] = explode('-W', $minggu);
                            $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                            $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                            $q->whereBetween('tanggal_terima', [$startOfWeek, $endOfWeek]);
                        }
                    case 'bulanan':
                        if ($bulan) {
                            $tanggal = Carbon::parse($bulan);
                            $q->whereMonth('tanggal_terima', $tanggal->month)
                                ->whereYear('tanggal_terima', $tanggal->year);
                        }
                        break;
                    case 'tahunan':
                        if ($tahun) {
                            $q->whereYear('tanggal_terima', $tahun);
                        }
                        break;
                }
            });
        }
        $data = $query->get();
        session([
            'filter' => $filter,
            'tanggal' => $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('kasubag.reportterima', compact('data', 'message'));
    }
    public function resetfilterterima(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('kasubag.terima.surat'); // Redirect ke halaman utama laporan
    }

    public function tolakindex()
    {
        $data = SuratTolak::with('masterSurat')->get();
        return view('kasubag.reporttolak', compact('data')); // Pass the required data to the new view
    }
    public function filtertolak(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $query = SuratTolak::query()->with('masterSurat');
        if ($filter) {
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal, $minggu, $bulan, $tahun) {
                switch ($filter) {
                    case 'harian':
                        if ($tanggal) {
                            $tanggal = Carbon::parse($tanggal);
                            $q->whereDate('tanggal_tolak', $tanggal);
                        }
                        break;
                    case 'mingguan':
                        if ($minggu) {
                            [$year, $week] = explode('-W', $minggu);
                            $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                            $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                            $q->whereBetween('tanggal_tolak', [$startOfWeek, $endOfWeek]);
                        }
                    case 'bulanan':
                        if ($bulan) {
                            $tanggal = Carbon::parse($bulan);
                            $q->whereMonth('tanggal_tolak', $tanggal->month)
                                ->whereYear('tanggal_tolak', $tanggal->year);
                        }
                        break;
                    case 'tahunan':
                        if ($tahun) {
                            $q->whereYear('tanggal_tolak', $tahun);
                        }
                        break;
                }
            });
        }
        $data = $query->get();
        session([
            'filter' => $filter,
            'tanggal' => $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('kasubag.reporttolak', compact('data', 'message'));
    }
    public function resetfiltertolak(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('kasubag.tolak.surat'); // Redirect ke halaman utama laporan
    }

    public function Suratindex()
    {
        $data = MasterSurat::with('suratTerima', 'suratProses', 'suratTolak')->get();
        return view('kasubag.indexsurat', compact('data'));
    }
    public function terimaSurat($id)
    {
        $suratProses = SuratProses::where('id_surat', $id)->first();
        SuratTerima::create([
            'id_surat' => $suratProses->id_surat,
            'tanggal_terima' => now(),
            'catatan_terima' => 'Surat telah diterima.',
        ]);
        MasterSurat::where('id_surat', $id)->update(['status' => 'Terima']);
        $suratProses->delete();
        Alert::success('Selamat', 'Surat Berhasil Diterima');
        return redirect()->back();
    }
    public function tolakSurat($id)
    {
        // Ambil data surat dari `surat_proses`
        $suratProses = SuratProses::where('id_surat', $id)->first();

        // Pindahkan ke `surat_tolak`
        SuratTolak::create(
            [
                'id_surat' => $suratProses->id_surat,
                'tanggal_tolak' => Carbon::now(),
                'alasan_tolak' => 'Surat ditolak karena alasan tertentu.',
            ]
        );
        // Hapus dari `surat_proses`
        $suratProses->delete();
        // Perbarui status di `master_surat`
        MasterSurat::where('id_surat', $id)->update(['status' => 'Tolak']);
        Alert::warning('Selamat', 'Surat Berhasil Ditolak');
        return redirect()->back();
    }
    public function filtersurat(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $query = MasterSurat::query(); // Query dasar

        if ($filter) {
            switch ($filter) {
                case 'harian':
                    if ($tanggal) {
                        $tanggal = Carbon::parse($tanggal);
                        $query->whereDate('tanggal_surat', $tanggal);
                    }
                    break;
                case 'mingguan':
                    if ($minggu) {
                        [$year, $week] = explode('-W', $minggu);
                        $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                        $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                        $query->whereBetween('tanggal_surat', [$startOfWeek, $endOfWeek]);
                    }
                    break;
                case 'bulanan':
                    if ($bulan) {
                        $tanggal = Carbon::parse($bulan);
                        $query->whereMonth('tanggal_surat', $tanggal->month)
                            ->whereYear('tanggal_surat', $tanggal->year);
                    }
                    break;
                case 'tahunan':
                    if ($tahun) {
                        $query->whereYear('tanggal_surat', $tahun);
                    }
                    break;
            }
        }
        $data = $query->get(); // Data hasil filter
        session([
            'filter' => $filter,
            'tanggal' => $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('kasubag.indexsurat', compact('data', 'message'));
    }
    public function resetfiltersurat(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('kasubag.surat'); // Redirect ke halaman utama laporan
    }

}
