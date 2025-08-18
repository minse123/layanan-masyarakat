<?php

namespace App\Http\Controllers\SoalController;

use App\Models\SoalPelatihan;
use App\Models\KategoriSoalPelatihan;
use App\Models\JawabanPeserta;
use App\Imports\SoalImport;
use App\Exports\SoalExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SoalPelatihanController
{
    public function index(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $kategoriList = KategoriSoalPelatihan::orderBy('nama_kategori')->get();
        $soalQuery = SoalPelatihan::with('kategori');
        if ($request->filled('kategori')) {
            $soalQuery->where('id_kategori_soal_pelatihan', $request->kategori);
        }
        $soalList = $soalQuery->orderBy('id', 'desc')->get();

        return view('admin.soal.soal-pelatihan', compact('kategoriList', 'soalList', 'layout'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_soal_pelatihan' => 'required|exists:kategori_soal_pelatihan,id',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);
        SoalPelatihan::create($request->only([
            'id_kategori_soal_pelatihan',
            'pertanyaan',
            'pilihan_a',
            'pilihan_b',
            'pilihan_c',
            'pilihan_d',
            'jawaban_benar',
        ]));
        Alert::success('Berhasil', 'Soal berhasil ditambahkan!');
        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $soal = SoalPelatihan::findOrFail($id);
        $kategoriList = KategoriSoalPelatihan::orderBy('nama_kategori')->get();

        return view('admin.soal.edit-soal', compact('soal', 'kategoriList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori_soal_pelatihan' => 'required|exists:kategori_soal_pelatihan,id',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);
        $soal = SoalPelatihan::findOrFail($id);
        $soal->update($request->only([
            'id_kategori_soal_pelatihan',
            'pertanyaan',
            'pilihan_a',
            'pilihan_b',
            'pilihan_c',
            'pilihan_d',
            'jawaban_benar',
        ]));
        Alert::success('Berhasil', 'Soal berhasil diupdate!');
        return redirect()->back()->with('success', 'Soal berhasil diupdate.');
    }

    public function destroy($id)
    {
        $soal = SoalPelatihan::findOrFail($id);
        $soal->delete();
        alert()->success('Berhasil', 'Soal berhasil dihapus!');
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }

    public function importSoal(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new SoalImport, $request->file('file_excel'));
            Alert::success('Berhasil', 'Soal berhasil diimpor!');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat mengimpor soal: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function exportSoalExample()
    {
        return Excel::download(new SoalExport, 'contoh_soal.xlsx');
    }
}
