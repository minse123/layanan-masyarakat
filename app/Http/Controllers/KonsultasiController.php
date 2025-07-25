<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKonsultasi;
use App\Models\JawabPelatihan;
use App\Models\KategoriPelatihan;
use App\Models\JenisPelatihan;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class KonsultasiController extends Controller
{
    
    public function index()
    {
        $filter = session('filter', 'all_time');
        $tanggal = session('tanggal');
        $minggu = session('minggu');
        $bulan = session('bulan');
        $tahun = session('tahun');
        $statusFilter = session('status_filter', 'all'); // Default to 'all' for status filter

        // Determine if any active filter is present that requires redirecting to the filter method
        $hasActiveDateFilter = ($filter && $filter !== 'all_time');
        $hasActiveStatusFilter = ($statusFilter && $statusFilter !== 'all');

        if ($hasActiveDateFilter || $hasActiveStatusFilter) {
            return redirect()->route('admin.konsultasi.filter', [
                'filter' => $filter,
                'tanggal' => $tanggal,
                'minggu' => $minggu,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'status_filter' => $statusFilter,
            ]);
        }

        // If no active filters, fetch all consultations
        $konsultasi = MasterKonsultasi::with(['kategoriPelatihan.jenisPelatihan', 'jawabPelatihan'])->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")->get();
        return view('admin.konsultasi.index', compact('konsultasi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'judul_konsultasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis_kategori' => 'required|in:inti,pendukung',
            'tanggal_pengajuan' => 'required|date',
            // pelatihan_inti dan pelatihan_pendukung opsional tergantung kategori
        ]);

        // Simpan ke master_konsultasi
        $konsultasi = MasterKonsultasi::create([
            'id_user' => auth()->id() ?? null,
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'judul_konsultasi' => $request->judul_konsultasi,
            'deskripsi' => $request->deskripsi,
            'status' => 'Pending',
        ]);

        // Simpan ke kategori_pelatihan
        $kategori = KategoriPelatihan::create([
            'id_konsultasi' => $konsultasi->id_konsultasi,
            'jenis_kategori' => $request->jenis_kategori,
        ]);

        // Simpan ke jenis_pelatihan
        JenisPelatihan::create([
            'id_kategori' => $kategori->id_kategori,
            'pelatihan_inti' => $request->jenis_kategori == 'inti' ? $request->pelatihan_inti : null,
            'pelatihan_pendukung' => $request->jenis_kategori == 'pendukung' ? $request->pelatihan_pendukung : null,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
        ]);
        Alert::success('Berhasil', 'Data Konsultasi berhasil ditambahkan!');
        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Tampilkan detail konsultasi dengan relasi, termasuk jawaban
        $konsultasi = MasterKonsultasi::with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan' // relasi ke tabel jawab_konsultasi
        ])->findOrFail($id);

        return view('admin.konsultasi.show', compact('konsultasi'));
    }

    public function update(Request $request, $id)
    {
        $konsultasi = MasterKonsultasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'judul_konsultasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status' => 'required|in:Pending,Dijawab',
            'jawaban' => $request->status === 'Dijawab' ? 'required|string' : 'nullable',
        ]);

        $data = [
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'judul_konsultasi' => $request->judul_konsultasi,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ];

        if ($request->status === 'Dijawab') {
            $data['jawaban'] = $request->jawaban;
            $data['tanggal_dijawab'] = now();
        } else {
            $data['jawaban'] = null;
            $data['tanggal_dijawab'] = null;
        }

        $konsultasi->update($data);
        Alert::success('Berhasil', 'Data Konsultasi berhasil diperbarui!');
        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konsultasi = MasterKonsultasi::findOrFail($id);
        $konsultasi->delete();
        Alert::success('Berhasil', 'Data Konsultasi berhasil dihapus!');
        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus.');
    }

    public function answer(Request $request, $id)
    {
        $konsultasi = MasterKonsultasi::findOrFail($id);

        $request->validate([
            'jawaban' => 'required|string',
        ]);

        // Update status konsultasi
        $konsultasi->update([
            'status' => 'Dijawab',
        ]);

        // Simpan jawaban ke tabel jawab_konsultasi
        JawabPelatihan::updateOrCreate(
            ['id_konsultasi' => $id],
            [
                'jawaban' => $request->jawaban,
                'tanggal_dijawab' => now(),
            ]
        );

        // Kirim notifikasi WhatsApp melalui Fonnte
        try {
            $telepon = $konsultasi->telepon;
            if (substr($telepon, 0, 1) === '0') {
                $telepon = '62' . substr($telepon, 1);
            }

            $message = "Yth. {$konsultasi->nama},\n\n";
            $message .= "Jawaban untuk konsultasi Anda dengan judul \"{$konsultasi->judul_konsultasi}\" telah kami kirimkan.\n\n";
            $message .= "Pertanyaan anda {$konsultasi->deskripsi}\n\n";
            $message .= "Jawaban:\n*{$request->jawaban}*\n\n";
            $message .= "Terima kasih telah menggunakan layanan kami.\n";

            Http::withHeaders([
                'Authorization' => env('FONNTE_API_KEY'),
            ])->post('https://api.fonnte.com/send', [
                        'target' => $telepon,
                        'message' => $message,
                    ]);
        } catch (Exception $e) {
            // Tangani error jika pengiriman gagal, misalnya dengan logging
            Log::error('Gagal mengirim notifikasi WhatsApp: ' . $e->getMessage());
        }

        Alert::success('Berhasil', 'Data Konsultasi berhasil dijawab!');
        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dijawab.');
    }
    public function filter(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        $minggu = $request->minggu;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $statusFilter = $request->status_filter;

        $query = MasterKonsultasi::with(['kategoriPelatihan.jenisPelatihan'])->orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END");

        if ($filter && $filter !== 'all_time') {
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

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $konsultasi = $query->get();
        session([
            'filter' => $filter,
            'tanggal' => $tanggal,
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status_filter' => $statusFilter,
        ]);

        $message = '';
        if ($konsultasi->isEmpty()) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }
        return view('admin.konsultasi.index', compact('konsultasi', 'message'));
    }
    public function resetfilter(Request $request)
    {
        $request->session()->forget(['filter', 'tanggal', 'minggu', 'bulan', 'tahun', 'status_filter']);
        return redirect()->route('admin.konsultasi.index');
    }
}