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
                \Log::info('SuratProses ditemukan:', ['id_surat' => $suratProses]);
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
        try {
            \DB::beginTransaction(); // Mulai transaksi database

            // Ambil data surat dari surat_proses menggunakan Eloquent
            $suratProses = SuratProses::where('id_surat', $id)->first();
            if ($suratProses) {
                \Log::info('SuratProses ditemukan:', ['id_surat' => $suratProses->id_surat]);

                // Simpan data ke surat_terima menggunakan Eloquent
                $suratTerima = SuratTerima::create([
                    'id_surat' => $suratProses->id_surat,
                    'id_proses' => $suratProses->id_proses,
                    'tanggal_terima' => now(),
                    'catatan_terima' => 'Surat telah diterima.',
                ]);

                if ($suratTerima) {
                    \Log::info('Surat berhasil disimpan ke surat_terima:', ['id_surat' => $suratTerima]);

                    // Perbarui status di master_surat menggunakan Eloquent
                    $masterSurat = MasterSurat::find($id);
                    if ($masterSurat) {
                        $masterSurat->update(['status' => 'Terima']);
                        \Log::info('Status master_surat diperbarui:', ['id_surat' => $id]);

                        // Hapus data surat dari surat_proses menggunakan Eloquent
                        if ($suratProses->delete()) {
                            \Log::info('SuratProses berhasil dihapus:', ['id_surat' => $id]);
                            \DB::commit(); // Simpan transaksi jika semua berhasil
                            return redirect()->back()->with('success', 'Surat berhasil diterima.');
                        } else {
                            throw new \Exception("Gagal menghapus data dari surat_proses.");
                        }

                    }

                } else {
                    throw new \Exception("Gagal menyimpan data ke surat_terima.");
                }
            } else {
                return redirect()->back()->with('error', 'Surat tidak ditemukan di surat_proses.');
            }
        } catch (\Exception $e) {
            \DB::rollBack(); // Batalkan transaksi jika ada kesalahan
            \Log::error('Error terima surat: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function tolakSurat($id)
    {
        // Ambil data surat dari `surat_proses`
        $suratProses = SuratProses::where('id_surat', $id)->first();

        if (!$suratProses) {
            return redirect()->back()->with('error', 'Surat tidak ditemukan dalam proses.');
        }

        // Pindahkan ke `surat_tolak`
        SuratTolak::updateOrCreate(
            ['id_surat' => $suratProses->id_surat],
            [
                'id_proses' => $suratProses->id_proses,
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
                        'id_proses' => $idProses,
                    ]
                );
            } elseif ($request->status == 'Tolak') {
                SuratTolak::updateOrCreate(
                    ['id_surat' => $id],
                    [
                        'tanggal_tolak' => now(),
                        'alasan_tolak' => $request->keterangan ?? null,
                        'id_proses' => $idProses,
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
