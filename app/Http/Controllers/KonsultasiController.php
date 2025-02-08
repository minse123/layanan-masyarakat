<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKonsultasi; // Model for consultations
use App\Models\KonsultasiPending; // Model for pending consultations
use App\Models\KonsultasiDijawab; // Model for answered consultations
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade

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
        ]);

        // Save consultation data
        $konsultasi = MasterKonsultasi::create($request->all());

        // Save pending consultation data
        KonsultasiPending::create([
            'id_konsultasi' => $konsultasi->id,
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('admin.konsultasi.index')->with('success', 'Konsultasi berhasil ditambahkan.');
    }

    public function show(MasterKonsultasi $konsultasi)
    {
        // Display consultation details
        return view('admin.konsultasi.show', compact('konsultasi'));
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
            'jawaban' => 'required_if:status,Dijawab|string',
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


}