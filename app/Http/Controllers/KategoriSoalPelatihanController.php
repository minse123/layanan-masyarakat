<?php

namespace App\Http\Controllers;

use App\Models\KategoriSoalPelatihan;
use Illuminate\Http\Request;

class KategoriSoalPelatihanController extends Controller
{
    public function index()
    {
        $kategori = KategoriSoalPelatihan::orderBy('id', 'desc')->get();
        return view('admin.soal.kategori_soal_pelatihan', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'tipe' => 'required|in:inti,pendukung',
        ]);
        KategoriSoalPelatihan::create($request->only('nama_kategori', 'tipe'));
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'tipe' => 'required|in:inti,pendukung',
        ]);
        $kategori = KategoriSoalPelatihan::findOrFail($id);
        $kategori->update($request->only('nama_kategori', 'tipe'));
        return redirect()->back()->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategori = KategoriSoalPelatihan::findOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}