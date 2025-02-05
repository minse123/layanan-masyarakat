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
                SuratProses::create([
                    'id_surat' => $surat->id_surat,
                    'tanggal_proses' => now(),
                    'catatan_proses' => $request->catatan_proses,
                ]);
                // dd($suratProses);
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
        // dd($id);
        // Ambil data surat dari `surat_proses`
        $suratProses = SuratProses::where('id_surat', $id)->firstOrFail();
        // dd($suratProses);

        // Pindahkan ke `surat_terima`
        SuratTerima::create([
            'id_surat' => $suratProses->id_surat,
            'id_proses' => $suratProses->id_proses,
            'tanggal_terima' => Carbon::now(),
            'catatan_terima' => 'Surat telah diterima.'
        ]);
        // Hapus dari `surat_proses`
        $suratProses->delete();

        // Perbarui status di `master_surat`
        MasterSurat::where('id_surat', $id)->update(['status' => 'Terima']);

        return redirect()->back()->with('success', 'Surat berhasil diterima.');
    }

    public function tolakSurat($id)
    {
        // Ambil data surat dari `surat_proses`
        $suratProses = SuratProses::where('id_surat', $id)->firstOrFail();

        // Pindahkan ke `surat_tolak`
        SuratTolak::create([
            'id_surat' => $suratProses->id_surat,
            'id_proses' => $suratProses->id_proses,
            'tanggal_tolak' => Carbon::now(),
            'alasan_tolak' => 'Surat ditolak karena alasan tertentu.'
        ]);

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
        $surat = SuratProses::findOrFail($id);
        $surat = SuratTerima::findOrFail($id);
        $surat = SuratTolak::findOrFail($id);
        // Validasi data yang diterima
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string',
            'status' => 'required|string|in:Proses,Terima,Tolak',
            'keterangan' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi file jika ada
        ]);

        // Temukan surat berdasarkan ID
        $surat = MasterSurat::findOrFail($id);

        // Update data surat
        $surat->nomor_surat = $request->nomor_surat;
        $surat->tanggal_surat = $request->tanggal_surat;
        $surat->pengirim = $request->pengirim;
        $surat->perihal = $request->perihal;
        $surat->status = $request->status;
        $surat->keterangan = $request->keterangan;

        // Jika ada file yang diunggah, simpan file dan update path
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($surat->file_path) {
                Storage::delete($surat->file_path);
            }
            // Simpan file baru
            $filePath = $request->file('file')->store('uploads', 'public');
            $surat->file_path = $filePath;
        }

        // Simpan perubahan ke database
        $surat->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.surat.index')->with('success', 'Data surat berhasil diperbarui.');

    }



    public function Masukindex(
    ) {
        $data = SuratTerima::with('masterSurat')->get();
        // dd($data);
        return view('admin.surat.masuk.index', compact('data'));
    }

    // Update data surat masuk
    public function updateData(Request $request)
    {
        dd($request->all());
        $request->validate([
            'id' => 'required|exists:surat_masuk,id_masuk',
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'tanggal_terima' => 'required|date',
            'disposisi' => 'nullable',
        ]);

        $suratMasuk = SuratTerima::findOrFail($request->id);
        $masterSurat = MasterSurat::findOrFail($suratMasuk->id_surat);
        // dd($masterSurat, $suratMasuk);
        $masterSurat->update([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
        ]);

        $suratMasuk->update([
            'tanggal_terima' => $request->tanggal_terima,
            'disposisi' => $request->disposisi,
        ]);

        // dd($suratMasuk, $masterSurat);

        return redirect()->route('admin.surat-masuk')->with('status', 'Surat masuk berhasil diperbarui!');
    }

    // Hapus data surat masuk
    public function hapusData(Request $request)
    {
        $suratMasuk = SuratTerima::findOrFail($request->id);
        $masterSurat = MasterSurat::findOrFail($suratMasuk->master_surat_id);

        $suratMasuk->delete();
        $masterSurat->delete();

        return redirect()->route('admin.surat-masuk')->with('status', 'Surat masuk berhasil dihapus!');
    }

    public function filterData(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = SuratTerima::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_surat', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_surat', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_surat', $tanggal->month)
                            ->whereYear('tanggal_surat', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_surat', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        session(['filter' => $filter, 'tanggal' => $tanggal]);
        // dd($request->all());
        return view('admin.surat.masuk.index', compact('data'));
    }
    public function cetakPDF(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');

        $query = SuratTerima::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_surat', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_surat', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_surat', $tanggal->month)
                            ->whereYear('tanggal_surat', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_surat', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();

        $pdf = PDF::loadView('admin.surat.masuk.formCetakPDF', compact('data'));
        return $pdf->stream('laporan-surat-masuk.pdf');
    }
}
