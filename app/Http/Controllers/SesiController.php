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
            if ($user->role === 'masyarakat') {
                Alert()->success('Login Berhasil', 'Selamat datang di dashboard!');
                return redirect('/masyarakat/dashboard')->with('message', 'Selamat datang, Masyarakat!');
            }
        }
        alert()->error('Login Gagal', 'Email atau password salah.');
        return back()->with('salah', 'Email atau password salah.')->withInput();
    }

    public function indexPegawai()
    {
        return view('auth.login-pegawai');
    }

    public function loginPegawai(Request $request)
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
                    Alert()->success('Login Berhasil', 'Selamat datang di dashboard!');
                    return redirect('/admin/dashboard')->with('message', 'Selamat datang, Admin');
                case 'psm':
                    return redirect('/psm/dashboard')->with('message', 'Selamat datang, PSM');
                case 'kasubag':
                    return redirect('/kasubag/dashboard')->with('message', 'Selamat datang, Kasubag!');
                default:
                    Auth::logout();
                    alert()->error('Login Gagal', 'Anda tidak memiliki akses.');
                    return back()->with('salah', 'Anda tidak memiliki akses.')->withInput();
            }
        }
        alert()->error('Login Gagal', 'Email atau password salah.');
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
            'role' => 'masyarakat', // Default role
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
        alert()->success('Berhasil', 'Anda berhasil logout.');
        return redirect('/login')->with('message', 'Anda berhasil logout.');
    }

}
