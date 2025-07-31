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
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class SuratController extends Controller
{
        public function Suratindex(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $query = MasterSurat::query();

        $filter = $request->input('filter', 'all_time');
        $tanggal = $request->input('tanggal');
        $statusFilter = $request->input('status_filter', 'all');

        if ($filter !== 'all_time') {
            $this->applyDateFilter($query, 'tanggal_surat', $filter, $tanggal);
        }

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $masterSurat = $query->get();

        return view('admin.surat.index', compact('masterSurat', 'layout'));
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
            'telepon' => 'required|string|max:255',
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
                'telepon' => $request->telepon,
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
            }
            Alert::success('Selamat', 'Surat Berhasil Ditambahkan');
            return redirect()->back();
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
        Alert::success('Berhasil', 'Surat berhasil diterima.');
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
        Alert::success('Ditolak', 'Surat berhasil ditolak.');
        return redirect()->back();
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
            'telepon' => 'required|string|max:255',
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
            'telepon' => $request->telepon,
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
        alert()->success('Berhasil', 'Data surat berhasil diperbarui.');
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
        alert()->success('Berhasil', 'Data surat berhasil dihapus.');
        return redirect()->route('admin.master.surat')->with('success', 'Data surat berhasil dihapus.');
    }



    private function applyDateFilter($query, $dateColumn, $filter, $date)
    {
        if ($filter && $date) {
            if ($filter === 'tahunan') {
                $query->whereYear($dateColumn, $date);
                return $query;
            }

            $carbonDate = Carbon::parse($date);
            switch ($filter) {
                case 'harian':
                    $query->whereDate($dateColumn, $carbonDate);
                    break;
                case 'mingguan':
                    $query->whereBetween($dateColumn, [$carbonDate->startOfWeek(), $carbonDate->endOfWeek()]);
                    break;
                case 'bulanan':
                    $query->whereMonth($dateColumn, $carbonDate->month)
                        ->whereYear($dateColumn, $carbonDate->year);
                    break;
            }
        }
        return $query;
    }
}

