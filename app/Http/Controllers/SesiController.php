<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class SesiController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8'
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Masukkan alamat email yang valid.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password harus minimal 8 karakter.',
            ]
        );

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    Alert::success('Login Berhasil', 'Selamat datang di dashboard!');
                    return redirect('/admin/dashboard')->with('message', 'Selamat datang, Operator!');
                case 'psm':
                    return redirect('/psm/dashboard')->with('message', 'Selamat datang, PSM');
                case 'kasubag':
                    return redirect('/kasubag/dashboard')->with('message', 'Selamat datang, Kasubag!');
                case 'masyarakat':
                    return redirect('/masyarakat/dashboard')->with('message', 'Selamat datang, Masyarakat!');
                default:
                    return redirect('/')->with('message', 'Berhasil login.');
            }
        }

        return back()->with('salah', 'Email atau password salah.')->withInput();

    }

    public function register()
    {
        return view('auth.register');
    }

    public function simpanRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'telepon' => 'required',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => bcrypt($request->password),
            'role' => 'user', // Default role
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Anda berhasil logout.');
    }

}
