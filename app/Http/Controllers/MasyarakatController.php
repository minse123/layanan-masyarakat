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

        return view('masyarakat.dashboard', compact('videos', 'konsultasi'));
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
}
