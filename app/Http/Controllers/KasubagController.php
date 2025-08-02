<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SuratProses;
use App\Models\SuratTerima;
use App\Models\SuratTolak;
use App\Models\MasterSurat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class KasubagController extends Controller
{
    public function index()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $totalSuratProses = SuratProses::count();
        $totalSuratTerima = SuratTerima::count();
        $totalSuratTolak = SuratTolak::count();
        $totalMasterSurat = MasterSurat::count();

        return view('admin.dashboard.kasubag', compact(
            'layout',
            'totalSuratProses',
            'totalSuratTerima',
            'totalSuratTolak',
            'totalMasterSurat',
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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