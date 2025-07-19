<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Video;
use App\Models\MasterKonsultasi;
use App\Models\KategoriSoalPelatihan;
use App\Models\SoalPelatihan;
use App\Models\JawabanPeserta;
use App\Models\MasterSurat;
use App\Models\SuratProses;
use App\Models\HasilPelatihan;
use App\Models\JadwalPelatihan;

class MasyarakatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Logging akses dashboard oleh masyarakat
        Log::info('Masyarakat dashboard accessed', [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'user_name' => $user?->name,
            'access_time' => now(),
        ]);

        // Ambil video yang ditampilkan (publish)
        $videos = Video::where('ditampilkan', 1)
            ->latest()
            ->take(4)
            ->get();

        // Ambil riwayat konsultasi milik user login
        $konsultasi = MasterKonsultasi::where('id_user', $user->id ?? 0)
            ->latest()
            ->take(10)
            ->get();

        // Ambil 5 jadwal pelatihan terbaru
        $jadwalPelatihan = JadwalPelatihan::latest()->take(4)->get();

        // Ambil kategori soal pelatihan untuk modal
        $kategoriList = KategoriSoalPelatihan::orderBy('nama_kategori')->get();

        return view('masyarakat.dashboard', compact('videos', 'konsultasi', 'kategoriList', 'jadwalPelatihan'));
    }


    public function semuaVideo(Request $request)
    {
        $konsultasi = MasterKonsultasi::where('id_user', $user->id ?? 0)
            ->latest()
            ->take(10)
            ->get();
        $query = Video::where('ditampilkan', 1);

        if ($request->jenis_pelatihan) {
            $query->where('jenis_pelatihan', $request->jenis_pelatihan);
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('masyarakat.videopelatihan', compact('videos', 'konsultasi'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->alamat = $request->alamat;
        $user->nik = $request->nik;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        Alert::success('Berhasil', 'Profil berhasil diperbarui!');
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function storeSurat(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:master_surat,nomor_surat',
            'tanggal_surat' => 'required|date',
            'perihal' => 'nullable|string|max:255',
            'pengirim' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'catatan_proses' => 'nullable|string',
            'id_user' => 'nullable|exists:users,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        // dd($request->all());
        // Menyimpan file dan mendapatkan path
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            \Log::info('File uploaded: ' . $filePath); // Log file path
        }

        // Membuat entri di MasterSurat
        $surat = MasterSurat::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal' => $request->perihal,
            'pengirim' => $request->pengirim,
            'telepon' => $request->telepon,
            'status' => 'Proses',
            'keterangan' => null,
            'id_user' => null,
            'file_path' => $filePath,
        ]);


        if ($surat) {
            // Langsung masuk ke proses
            SuratProses::create([
                'id_surat' => $surat->id_surat,
                'tanggal_proses' => now(),
                'catatan_proses' => $request->catatan_proses,
            ]);

        }

        Alert::success('Selamat', 'Data Berhasil Disimpan');
        return back()->with('status', 'Data Berhasil Disimpan');
    }

    // Tampilkan daftar kategori soal (untuk modal atau halaman)
    public function kategori()
    {
        $kategoriList = KategoriSoalPelatihan::orderBy('nama_kategori')->get();
        return view('masyarakat.soal.latihan', compact('kategoriList', ));
    }

    // Tampilkan soal-soal berdasarkan kategori yang dipilih
    public function latihan($kategoriId)
    {
        $user = Auth::user();

        // Logging akses dashboard oleh masyarakat
        Log::info('Masyarakat dashboard accessed', [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'user_name' => $user?->name,
            'access_time' => now(),
        ]);

        $konsultasi = MasterKonsultasi::where('id_user', $user->id ?? 0)
            ->latest()
            ->take(10)
            ->get();

        $kategori = KategoriSoalPelatihan::findOrFail($kategoriId);

        // Check if the user has already answered questions for this category
        $hasAnswered = JawabanPeserta::where('id_user', $user->id)
            ->whereHas('soal', function ($query) use ($kategoriId) {
                $query->where('id_kategori_soal_pelatihan', $kategoriId);
            })
            ->exists();

        if ($hasAnswered) {
            return redirect()->route('masyarakat.soal.hasil', ['jenis_pelatihan' => $kategoriId]);
        }

        $soalList = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategoriId)->get();
        return view('masyarakat.soal.latihan', compact('kategori', 'soalList', 'konsultasi'));
    }

    public function storeSoal(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|string',
        ]);

        $userId = Auth::id();

        foreach ($request->jawaban as $soal_id => $jawaban) {
            $soal = SoalPelatihan::find($soal_id);

            if (!$soal) {
                \Log::warning('Soal tidak ditemukan', ['id_soal' => $soal_id]);
                continue;
            }

            $isBenar = strtolower(trim($soal->jawaban_benar)) === strtolower(trim($jawaban)) ? 1 : 0;

            JawabanPeserta::updateOrCreate(
                ['id_user' => $userId, 'id_soal' => $soal_id],
                ['jawaban_peserta' => $jawaban, 'benar' => $isBenar]
            );
        }
        alert()->success('Berhasil', 'Jawaban berhasil disimpan!');
        return redirect()->route('masyarakat.soal.hasil')->with('success', 'Jawaban berhasil disimpan!');
    }

    public function hasil(Request $request)
    {
        $user = Auth::user();

        $userId = Auth::id();

        $konsultasi = MasterKonsultasi::where('id_user', $user->id ?? 0)
            ->latest()
            ->take(10)
            ->get();

        $query = JawabanPeserta::with(['soal', 'soal.kategori'])
            ->where('id_user', $userId);

        // Filter by jenis_pelatihan
        if ($request->has('jenis_pelatihan') && $request->jenis_pelatihan != '') {
            $query->whereHas('soal', function ($q) use ($request) {
                $q->where('id_kategori_soal_pelatihan', $request->jenis_pelatihan);
            });
        }

        $jawabanPeserta = $query->get()
            ->map(function ($item) {
                // Tambahkan field is_correct yang jelas
                $item->is_correct = $item->benar == 1;
                return $item;
            });

        // Hitung skor berdasarkan field benar
        $skor = $jawabanPeserta->sum('benar');
        $totalSoal = $jawabanPeserta->count();

        $jenisPelatihan = KategoriSoalPelatihan::orderBy('nama_kategori')->get();

        $kategori = null;
        if ($request->has('jenis_pelatihan') && $request->jenis_pelatihan != '') {
            $kategori = KategoriSoalPelatihan::find($request->jenis_pelatihan);
        }

        return view('masyarakat.soal.hasil', [
            'konsultasi' => $konsultasi,
            'jawabanPeserta' => $jawabanPeserta,
            'skor' => $skor,
            'totalSoal' => $totalSoal,
            'jenisPelatihan' => $jenisPelatihan,
            'kategori' => $kategori
        ]);
    }


    public function jadwalPelatihan(Request $request)
    {
        $user = Auth::user();
        $konsultasi = MasterKonsultasi::where('id_user', $user->id ?? 0)
            ->latest()
            ->take(10)
            ->get();

        $query = JadwalPelatihan::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pelatihan', 'like', '%' . $request->search . '%');
        }

        if ($request->has('jenis_pelatihan') && $request->jenis_pelatihan != '') {
            if ($request->jenis_pelatihan == 'pelatihan_inti') {
                $query->whereNotNull('pelatihan_inti');
            } elseif ($request->jenis_pelatihan == 'pelatihan_pendukung') {
                $query->whereNotNull('pelatihan_pendukung');
            }
        }

        $data = $query->paginate(10);
        return view('masyarakat.jadwal-pelatihan', compact('data', 'konsultasi'));
    }

}