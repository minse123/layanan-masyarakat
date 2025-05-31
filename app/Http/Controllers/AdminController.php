<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tamu;
use App\Models\KonsultasiPending;
use App\Models\KonsultasiDijawab;
use App\Models\SuratProses;
use App\Models\SuratTerima;
use App\Models\SuratTolak;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{


    public function index()
    {
        $totalTamu = Tamu::count();
        $totalKonsultasiPending = KonsultasiPending::count();
        $totalKonsultasiDijawab = KonsultasiDijawab::count();
        $totalSuratProses = SuratProses::count();
        $totalSuratTerima = SuratTerima::count();
        $totalSuratTolak = SuratTolak::count();

        return view('admin.dashboard', compact(
            'totalTamu',
            'totalKonsultasiPending',
            'totalKonsultasiDijawab',
            'totalSuratProses',
            'totalSuratTerima',
            'totalSuratTolak'
        ));
    }
    public function authIndex()
    { {
            $users = User::all(); // Mengambil semua data pengguna
            return view('admin.auth.index', compact('users')); // Pastikan nama view benar
        }
    }
    public function authTambah()
    {
        $user = User::all();
        return view('admin.auth.auth-formTambah');
    }
    public function authSimpan(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Disimpan');
    }
    public function authEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.auth.auth-formEdit', compact('user'));
    }
    public function authUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Diperbarui');
    }
    public function authHapus(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Dihapus');
    }

    public function dataTamu()
    {
        $data = Tamu::all();
        return view('admin.tamu.index', compact('data'));
    }

    public function simpanData(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'instansi' => 'nullable',
            'email' => 'nullable|email',
            'keperluan' => 'required',
            'date' => 'required|date',
        ]);

        Tamu::create($request->all());

        return redirect()->route('admin.index')->with('status', 'Data tamu berhasil ditambahkan!');
    }

    public function updateTamu(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'instansi' => 'nullable',
            'email' => 'nullable|email',
            'keperluan' => 'required',
            'date' => 'required|date',
        ]);

        $tamu = Tamu::findOrFail($request->id);
        $tamu->update($request->all());

        return redirect()->route('admin.tamu')->with('status', 'Data tamu berhasil diperbarui!');
    }

    public function hapusTamu(Request $request)
    {
        $tamu = Tamu::findOrFail($request->id);
        $tamu->delete();

        return redirect()->route('admin.tamu')->with('status', 'Data tamu berhasil dihapus!');
    }
    public function filterData(Request $request)
    {
        $filter = $request->filter;
        $query = Tamu::query();

        // Hapus semua session filter sebelumnya
        session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']);

        if ($filter) {
            switch ($filter) {
                case 'harian':
                    if ($request->tanggal) {
                        $query->whereDate('date', $request->tanggal);
                        session(['tanggal' => $request->tanggal]);
                    }
                    break;

                case 'mingguan':
                    if ($request->minggu) {
                        $start = Carbon::parse($request->minggu)->startOfWeek();
                        $end = Carbon::parse($request->minggu)->endOfWeek();
                        $query->whereBetween('date', [$start, $end]);
                        session(['minggu' => $request->minggu]);
                    }
                    break;

                case 'bulanan':
                    if ($request->bulan) {
                        $query->whereMonth('date', date('m', strtotime($request->bulan)))
                            ->whereYear('date', date('Y', strtotime($request->bulan)));
                        session(['bulan' => $request->bulan]);
                    }
                    break;

                case 'tahunan':
                    if ($request->tahun) {
                        $query->whereYear('date', $request->tahun);
                        session(['tahun' => $request->tahun]);
                    }
                    break;
            }

            session(['filter' => $filter]); // Simpan filter yang dipilih
        }

        $data = $query->get();

        return view('admin.tamu.index', compact('data'));
    }

    public function resetfilterData(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.tamu'); // Redirect ke halaman utama laporan
    }



    //form report
    public function reportdataTamu()
    {
        $data = Tamu::all();
        return view('admin.tamu.reporttamu', compact('data'));
    }
    public function reportfilterData(Request $request)
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
            'tanggal' => $tanggal instanceof Carbon ? $tanggal->toDateString() : $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('admin.tamu.reporttamu', compact('data', 'message'));
    }
    public function reportresetfilterData(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun']); // Hapus session filter
        return redirect()->route('admin.report.tamu'); // Redirect ke halaman utama laporan
    }


    public function cetakPDF(Request $request)
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


}


