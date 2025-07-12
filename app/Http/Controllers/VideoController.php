<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Video;
use RealRashid\SweetAlert\Facades\Alert;


class VideoController extends Controller
{

    
    // Tampilkan daftar video & form tambah
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.video.video', compact('videos'));
    }

    // Simpan video baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'youtube_id' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jenis_pelatihan' => 'required|in:inti,pendukung', // Tambahkan validasi ini
        ]);

        // Ambil ID video dari link atau langsung ID
        $youtube_id = $this->extractYoutubeId($request->youtube_id);

        Video::create([
            'judul' => $request->judul,
            'youtube_id' => $youtube_id,
            'deskripsi' => $request->deskripsi,
            'jenis_pelatihan' => $request->jenis_pelatihan, // Simpan jenis pelatihan
        ]);
        Alert::success('Berhasil', 'Video berhasil ditambahkan!');
        return redirect()->back()->with('success', 'Video berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        Alert::success('Berhasil', 'Video berhasil diedit.');
        return view('admin.video.edit', compact('video'));
    }

    // Update video
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'youtube_id' => 'required|string',
            'deskripsi' => 'nullable|string',
            'ditampilkan' => 'required|boolean',
            'jenis_pelatihan' => 'required|in:inti,pendukung', // Tambahkan validasi ini
        ]);

        $youtube_id = $this->extractYoutubeId($request->youtube_id);
        $video = Video::findOrFail($id);
        $video->update([
            'judul' => $request->judul,
            'youtube_id' => $youtube_id,
            'deskripsi' => $request->deskripsi,
            'ditampilkan' => $request->ditampilkan,
            'jenis_pelatihan' => $request->jenis_pelatihan, // Update jenis pelatihan
        ]);

        Alert::success('Berhasil', 'Video berhasil diupdate!');
        return redirect()->route('admin.video.index')->with('success', 'Video berhasil diupdate!');
    }

    // Hapus video
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        Alert::success('Berhasil', 'Video berhasil dihapus!');
        return redirect()->back()->with('success', 'Video berhasil dihapus!');
    }

    // Helper: Ambil ID dari link YouTube
    private function extractYoutubeId($url)
    {
        // Jika sudah ID, langsung return
        if (preg_match('/^[\w-]{11}$/', $url)) {
            return $url;
        }
        // Ambil ID dari url
        if (preg_match('/(?:v=|\/embed\/|\.be\/)([\w-]{11})/', $url, $matches)) {
            return $matches[1];
        }
        return $url; // fallback
    }
}