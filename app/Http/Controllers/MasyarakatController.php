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
use App\Models\HasilPelatihan;

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

        // Ambil kategori soal pelatihan untuk modal
        $kategoriList = KategoriSoalPelatihan::orderBy('nama_kategori')->get();

        return view('masyarakat.dashboard', compact('videos', 'konsultasi', 'kategoriList'));
    }


    public function semuaVideo(Request $request)
    {
        $query = Video::where('ditampilkan', 1);

        if ($request->jenis_pelatihan) {
            $query->where('jenis_pelatihan', $request->jenis_pelatihan);
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('masyarakat.videopelatihan', compact('videos'));
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

    public function hasil()
    {
        $konsultasi = MasterKonsultasi::where('id_user', $user->id ?? 0)
            ->latest()
            ->take(10)
            ->get();

        $userId = Auth::id();
        $jawabanPeserta = JawabanPeserta::with('soal')
            ->where('id_user', $userId)
            ->get();

        // Hitung skor (misalnya: jawaban benar = +1)
        $skor = 0;
        foreach ($jawabanPeserta as $item) {
            if (strtolower(trim($item->jawaban_peserta)) === strtolower(trim($item->soal->jawaban_benar))) {
                $skor++;
            }
        }

        return view('masyarakat.soal.hasil', [
            'jawabanPeserta' => $jawabanPeserta,
            'skor' => $skor,
            'totalSoal' => SoalPelatihan::count(),
            'konsultasi' => $konsultasi,
        ]);
    }

}