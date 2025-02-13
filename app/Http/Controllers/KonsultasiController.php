<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKonsultasi; // Model for consultations
use App\Models\KonsultasiPending; // Model for pending consultations
use App\Models\KonsultasiDijawab; // Model for answered consultations
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade
use Carbon\Carbon; // Import Carbon

class KonsultasiController extends Controller
{
    public function index()
    {
        // Retrieve all consultation data
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])->get();
        return view('admin.konsultasi.index', compact('konsultasi'));
    }
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'judul_konsultasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
        ]);

        // Save consultation data
        $konsultasi = MasterKonsultasi::create($request->all());

        // Save pending consultation data
        KonsultasiPending::create([
            'id_konsultasi' => $konsultasi->id_konsultasi,
            'tanggal_pengajuan' => Carbon::now(),
        ]);

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }
    public function show(Request $request, MasterKonsultasi $konsultasi)
    {
        // Display consultation details
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])->get();
        return view('admin.konsultasi.index', compact('konsultasi'));
    }
    public function update(Request $request, $id)
    {
        $konsultasi = MasterKonsultasi::findOrFail($id);
        $currentStatus = $konsultasi->getOriginal('status');

        // Save the answer
        // Validasi data yang diterima
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'judul_konsultasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|string|in:Pending,Dijawab',
            'jawaban' => $request->status === 'Dijawab' ? 'required|string' : 'nullable',
        ]);

        // Update consultation data
        $konsultasi->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'judul_konsultasi' => $request->judul_konsultasi,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);
        // dd($konsultasi);


        // Jika status berubah, hapus data lama di tabel terkait
        if ($request->status !== $currentStatus) {
            if ($currentStatus == 'Pending') {
                KonsultasiPending::where('id_konsultasi', $id)->delete();
            } elseif ($currentStatus == 'Dijawab') {
                KonsultasiDijawab::where('id_konsultasi', $id)->delete();
            }

            // Simpan data baru sesuai status
            if ($request->status == 'Pending') {
                KonsultasiPending::updateOrCreate(
                    ['id_konsultasi' => $id],
                    [
                        'tanggal_pengajuan' => now(),
                    ]
                );
                // dd($request->status);
            } elseif ($request->status == 'Dijawab') {
                KonsultasiDijawab::updateOrCreate(
                    ['id_konsultasi' => $id],
                    [
                        'tanggal_dijawab' => now(),
                        'jawaban' => $request->jawaban ?? 'Belum ada jawaban',
                    ]
                );
            }
        }
        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dijawab.');
    }
    public function destroy(MasterKonsultasi $konsultasi)
    {
        // Delete consultation
        $konsultasi->delete();

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus.');
    }
    public function answer(Request $request, $id)
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


        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dijawab.');
    }
    public function filter(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = KonsultasiPending::query()->with('masterKonsultasi');
        $query = KonsultasiDijawab::query()->with('masterKonsultasi');


        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterKonsultasi', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_pengajuan', $tanggal)
                            ->orWhereDate('tanggal_dijawab', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_pengajuan', [$tanggal->startOfWeek(), $tanggal->endOfWeek()])
                            ->orWhereBetween('tanggal_dijawab', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_pengajuan', $tanggal->month)
                            ->whereYear('tanggal_pengajuan', $tanggal->year)
                            ->orWhereMonth('tanggal_dijawab', $tanggal->month)
                            ->whereYear('tanggal_dijawab', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_pengajuan', $tanggal->year)
                            ->orWhereYear('tanggal_dijawab', $tanggal->year);
                        break;
                }
            });
        }
        $data = $query->get();
        // Simpan filter ke session
        session(['filter' => $filter, 'tanggal' => $tanggal ? $tanggal->toDateString() : null]);
        session()->save();
        // Menyiapkan pesan notifikasi jika data kosong
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view('admin.konsultasi.index', compact('data', 'message'));
    }
    public function resetfilter(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.konsultasi.index'); // Redirect ke halaman utama laporan
    }



    public function pendingindex()
    {
        $data = KonsultasiPending::with('masterKonsultasi')->get();
        return view('admin.konsultasi.pending.reportpending', compact('data')); // Pass the required data to the new view
    }
    public function filterpending(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = KonsultasiPending::query()->with('masterKonsultasi');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterKonsultasi', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_pengajuan', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_pengajuan', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_pengajuan', $tanggal->month)
                            ->whereYear('tanggal_pengajuan', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_pengajuan', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        // Simpan filter ke session
        session(['filter' => $filter, 'tanggal' => $tanggal ? $tanggal->toDateString() : null]);
        session()->save();
        // Menyiapkan pesan notifikasi jika data kosong
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view('admin.konsultasi.pending.reportpending', compact('data', 'message'));
    }
    public function resetfilterpending(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.konsultasi.pending'); // Redirect ke halaman utama laporan
    }
    public function cetakpending(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');
        $query = KonsultasiPending::query()->with('masterKonsultasi');
        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterKonsultasi', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_pengajuan', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_pengajuan', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_pengajuan', $tanggal->month)
                            ->whereYear('tanggal_pengajuan', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_pengajuan', $tanggal->year);
                        break;
                }
            });
        }
        $data = $query->get();
        $pdf = PDF::loadView('admin.konsultasi.pending.formCetakPending', compact('data'));
        return $pdf->stream('laporan-konsultasi-pending.pdf');
    }


    public function dijawabindex()
    {
        $data = KonsultasiDijawab::with('masterKonsultasi')->get(); // Adjusted to get data from KonsultasiDijawab
        return view('admin.konsultasi.dijawab.reportdijawab', compact('data')); // Updated view to reflect the change
    }
    public function filterdijawab(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = KonsultasiDijawab::query()->with('masterKonsultasi');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterKonsultasi', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_dijawab', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_dijawab', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_dijawab', $tanggal->month)
                            ->whereYear('tanggal_dijawab', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_dijawab', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        // Simpan filter ke session
        session(['filter' => $filter, 'tanggal' => $tanggal ? $tanggal->toDateString() : null]);
        session()->save();
        // Menyiapkan pesan notifikasi jika data kosong
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view('admin.konsultasi.dijawab.reportdijawab', compact('data', 'message'));
    }
    public function resetfilterdijawab(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.konsultasi.dijawab'); // Redirect ke halaman utama laporan
    }
    public function cetakdijawab(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');
        $query = KonsultasiDijawab::query()->with('masterKonsultasi');
        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterKonsultasi', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_dijawab', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_dijawab', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_dijawab', $tanggal->month)
                            ->whereYear('tanggal_dijawab', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_dijawab', $tanggal->year);
                        break;
                }
            });
        }
        $data = $query->get();
        $pdf = PDF::loadView('admin.konsultasi.dijawab.formCetakDijawab', compact('data'));
        return $pdf->stream('laporan-konsultasi-dijawab.pdf');
    }
}