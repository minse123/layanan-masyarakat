<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKonsultasi; // Pastikan Anda memiliki model ini
use App\Models\KonsultasiPending; // Model untuk konsultasi_pending
use App\Models\KonsultasiDijawab; // Model untuk konsultasi_dijawab
use Barryvdh\DomPDF\Facade\Pdf;
// Import the PDF facade

class KonsultasiController extends Controller
{
    public function index()
    {
        // Mengambil semua data konsultasi
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])->get();
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
        ]);

        // Menyimpan data konsultasi
        $konsultasi = MasterKonsultasi::create($request->all());

        // Menyimpan data konsultasi_pending
        KonsultasiPending::create([
            'id_konsultasi' => $konsultasi->id,
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Menampilkan detail konsultasi
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])->findOrFail($id);
        return view('admin.konsultasi.show', compact('konsultasi'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jawaban' => 'required|string',
        ]);

        // Menyimpan jawaban untuk konsultasi
        $konsultasi = MasterKonsultasi::findOrFail($id);
        $konsultasi->status = 'Dijawab';
        $konsultasi->save();

        KonsultasiDijawab::create([
            'id_konsultasi' => $konsultasi->id,
            'jawaban' => $request->jawaban,
            'tanggal_dijawab' => now(),
        ]);

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dijawab.');
    }

    public function destroy($id)
    {
        // Menghapus konsultasi
        $konsultasi = MasterKonsultasi::findOrFail($id);
        $konsultasi->delete();

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil dihapus.');
    }

    public function cetakPDF()
    {
        // Mengambil semua data konsultasi
        $konsultasi = MasterKonsultasi::with(['konsultasiPending', 'konsultasiDijawab'])->get();

        // Membuat PDF
        $pdf = PDF::loadView('admin.konsultasi.pdf', compact('konsultasi'));

        // Mengatur ukuran kertas
        $pdf->setPaper('A4', 'landscape');

        // Mengunduh PDF
        return $pdf->download('data_konsultasi.pdf');
    }
}