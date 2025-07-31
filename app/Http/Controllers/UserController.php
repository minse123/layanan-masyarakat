<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
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

        // Cek apakah ada permintaan update password
        if ($request->filled('current_password') && $request->filled('new_password')) {
            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
            }

            // Update password menggunakan method khusus (jika ditambahkan ke Model)
            // $user->updatePassword($request->new_password);

            // Atau gunakan update method
            $user->update(['password' => Hash::make($request->new_password)]);

            // Skip save() karena update() sudah menyimpan
            Alert::success('Berhasil', 'Profil berhasil diperbarui.');
            return back();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->save();

        Alert::success('Berhasil', 'Profil berhasil diperbarui.');
        return back();
    }
}
