<?php

namespace App\Http\Controllers;

use App\Models\HasilPelatihan;
use App\Models\KategoriSoalPelatihan;
use App\Models\MasterKonsultasi;
use App\Models\SoalPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class PsmController extends Controller
{
    public function index()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };

        // Data Konsultasi
        $totalKonsultasi = MasterKonsultasi::count();
        $totalKonsultasiPending = MasterKonsultasi::where('status', 'Pending')->count();
        $totalKonsultasiDijawab = MasterKonsultasi::where('status', 'Dijawab')->count();

        // Data Ujian & Pelatihan
        $totalSoal = SoalPelatihan::count();
        $totalKategoriSoal = KategoriSoalPelatihan::count();
        $totalHasilPelatihan = HasilPelatihan::count();

        // Data for Charts
        $konsultasiStatusData = MasterKonsultasi::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();

        // Data for Recent Activities
        $recentKonsultasi = MasterKonsultasi::orderBy('created_at', 'desc')->limit(5)->get();
        $recentSoal = SoalPelatihan::with('kategori')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.psm', compact(
            'layout',
            'totalKonsultasi',
            'totalKonsultasiPending',
            'totalKonsultasiDijawab',
            'konsultasiStatusData',
            'recentKonsultasi',
            'totalSoal',
            'totalKategoriSoal',
            'totalHasilPelatihan',
            'recentSoal'
        ));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'telepon' => 'nullable|string|max:15',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;

        // Cek apakah ada permintaan update password
        if ($request->filled('current_password') && $request->filled('new_password')) {
            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        Alert::success('Berhasil', 'Profil berhasil diperbarui.');

        return back();
    }
}
