<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratTerima;
use App\Models\SuratProses;
use App\Models\SuratTolak;
use App\Models\MasterSurat;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function Suratindex()
    {
        $suratTolak = SuratTolak::all();
        $masterSurat = MasterSurat::all();
        $suratProses = SuratProses::all();
        $suratTerima = SuratTerima::all();
        return view('admin.surat.index', compact('suratTerima', 'masterSurat', 'suratProses', 'suratTolak'));
    }
    // MasterSurat View
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:master_surat,nomor_surat',
            'tanggal_surat' => 'required|date',
            'perihal' => 'nullable|string|max:255',
            'pengirim' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'catatan_proses' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        // Menyimpan file dan mendapatkan path
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        try {
            // Membuat entri di MasterSurat
            $surat = MasterSurat::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'perihal' => $request->perihal,
                'pengirim' => $request->pengirim,
                'status' => 'Proses',
                'keterangan' => $request->keterangan,
                'id_user' => auth()->id(),
                'file_path' => $filePath,
            ]);


            if ($surat) {
                // Langsung masuk ke proses
                $suratProses = SuratProses::create([
                    'id_surat' => $surat->id_surat,
                    'tanggal_proses' => now(),
                    'catatan_proses' => $request->catatan_proses,
                ]);
            } else {
                return redirect()->back()->withErrors(['error' => 'Gagal menyimpan surat.']);
            }
            return redirect()->back()->with('success', 'Surat masuk dalam proses');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    // Admin menerima surat
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
        return redirect()->back()->with('success', 'Surat berhasil diterima.');
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
        return redirect()->back()->with('success', 'Surat berhasil ditolak.');
    }
    public function MasterUpdate(Request $request, $id)
    {
        // Temukan surat berdasarkan ID
        $surat = MasterSurat::findOrFail($id);

        // Simpan status sebelum diubah
        $currentStatus = $surat->getOriginal('status');

        // Validasi data yang diterima
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string',
            'status' => 'required|string|in:Proses,Terima,Tolak',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Update data surat
        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        // Jika ada file yang diunggah, simpan file baru dan hapus file lama
        if ($request->hasFile('file')) {
            if ($surat->file_path) {
                Storage::delete($surat->file_path);
            }
            $filePath = $request->file('file')->store('uploads', 'public');
            $surat->file_path = $filePath;
            $surat->save();
        }

        // Jika status berubah, hapus data lama di tabel terkait
        if ($request->status !== $currentStatus) {
            if ($currentStatus == 'Terima') {
                SuratTerima::where('id_surat', $id)->delete();
            } elseif ($currentStatus == 'Tolak') {
                SuratTolak::where('id_surat', $id)->delete();
            } elseif ($currentStatus == 'Proses') {
                SuratProses::where('id_surat', $id)->delete();
            }

            // Ambil id_proses dari SuratProses jika ada
            $idProses = SuratProses::where('id_surat', $id)->value('id_proses');

            // Simpan data baru sesuai status
            if ($request->status == 'Terima') {
                SuratTerima::updateOrCreate(
                    ['id_surat' => $id],
                    [
                        'tanggal_terima' => now(),
                        'catatan_terima' => $request->keterangan ?? null,
                    ]
                );
            } elseif ($request->status == 'Tolak') {
                SuratTolak::updateOrCreate(
                    ['id_surat' => $id],
                    [
                        'tanggal_tolak' => now(),
                        'alasan_tolak' => $request->keterangan ?? null,
                    ]
                );
            } elseif ($request->status == 'Proses') {
                SuratProses::updateOrCreate(
                    ['id_surat' => $id],
                    [
                        'tanggal_proses' => now(),
                        'catatan_proses' => $request->keterangan ?? null,
                    ]
                );
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.master.surat')->with('success', 'Data surat berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Hapus data surat
        $surat = MasterSurat::findOrFail($id);
        $surat->delete();
        // Hapus data terkait
        SuratProses::where('id_surat', $id)->delete();
        SuratTerima::where('id_surat', $id)->delete();
        SuratTolak::where('id_surat', $id)->delete();
        // Redirect dengan pesan sukses
        return redirect()->route('admin.master.surat')->with('success', 'Data surat berhasil dihapus.');
    }
    public function filterSurat(Request $request)
    {
        $query = MasterSurat::query();

        if ($request->has('filter')) {
            $filter = $request->filter;
            $tanggal = $request->tanggal ? Carbon::parse($request->tanggal) : now();

            switch ($filter) {
                case 'harian':
                    $query->whereDate('tanggal_surat', $tanggal);
                    break;
                case 'mingguan':
                    $query->whereBetween('tanggal_surat', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                    break;
                case 'bulanan':
                    $query->whereMonth('tanggal_surat', $tanggal->month)->whereYear('tanggal_surat', $tanggal->year);
                    break;
                case 'tahunan':
                    $query->whereYear('tanggal_surat', $tanggal->year);
                    break;
            }
        }

        $masterSurat = $query->get();
        session(['filter' => $filter, 'tanggal' => $tanggal]);

        return view('admin.surat.index', compact('masterSurat'));
    }



    public function ProsesIndex()
    {
        $data = SuratProses::with('masterSurat')->get();
        return view('admin.surat.proses.reportproses', compact('data')); // Pass the required data to the view
    }
    public function filterproses(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = SuratProses::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_proses', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_proses', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_proses', $tanggal->month)
                            ->whereYear('tanggal_proses', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_proses', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        session(['filter' => $filter, 'tanggal' => $tanggal]);

        // Menyiapkan pesan notifikasi jika data kosong
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view('admin.surat.proses.reportproses', compact('data', 'message'));
    }
    public function resetfilterproses(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.proses.surat'); // Redirect ke halaman utama laporan
    }
    public function cetakproses(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');

        $query = SuratProses::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_proses', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_proses', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_proses', $tanggal->month)
                            ->whereYear('tanggal_proses', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_proses', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();

        $pdf = PDF::loadView('admin.surat.proses.formCetakProses', compact('data'));
        return $pdf->stream('laporan-surat-masuk.pdf');
    }


    public function terimaindex()
    {
        $data = SuratTerima::with('masterSurat')->get();
        return view('admin.surat.terima.reportterima', compact('data')); // Pass the required data to the new view
    }
    public function filterterima(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = SuratTerima::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_terima', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_terima', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_terima', $tanggal->month)
                            ->whereYear('tanggal_terima', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_terima', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        session(['filter' => $filter, 'tanggal' => $tanggal]);

        // Menyiapkan pesan notifikasi jika data kosong
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view('admin.surat.terima.reportterima', compact('data', 'message'));
    }
    public function resetfilterterima(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.terima.surat'); // Redirect ke halaman utama laporan
    }
    public function cetakterima(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');

        $query = SuratTerima::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_terima', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_terima', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_terima', $tanggal->month)
                            ->whereYear('tanggal_terima', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_terima', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();

        $pdf = PDF::loadView('admin.surat.terima.formCetakTerima', compact('data'));
        return $pdf->stream('laporan-surat-diterima.pdf');
    }



    public function tolakindex()
    {
        $data = SuratTolak::with('masterSurat')->get();
        return view('admin.surat.tolak.reporttolak', compact('data')); // Pass the required data to the new view
    }
    public function filtertolak(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = SuratTolak::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_tolak', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_tolak', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_tolak', $tanggal->month)
                            ->whereYear('tanggal_tolak', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_tolak', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        session(['filter' => $filter, 'tanggal' => $tanggal]);

        // Menyiapkan pesan notifikasi jika data kosong
        $message = '';
        if ($data->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view('admin.surat.tolak.reporttolak', compact('data', 'message'));
    }
    public function resetfiltertolak(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal']); // Hapus session filter
        return redirect()->route('admin.tolak.surat'); // Redirect ke halaman utama laporan
    }
    public function cetaktolak(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');
        $query = SuratTolak::query()->with('masterSurat');
        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_tolak', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_tolak', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_tolak', $tanggal->month)
                            ->whereYear('tanggal_tolak', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_tolak', $tanggal->year);
                        break;
                }
            });
        }
        $data = $query->get();
        $pdf = PDF::loadView('admin.surat.tolak.formCetakTolak', compact('data'));
        return $pdf->stream('laporan-surat-ditolak.pdf');
    }
}
