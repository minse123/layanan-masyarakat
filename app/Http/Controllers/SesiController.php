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
                alert()->success('Login Berhasil', 'Selamat datang di dashboard!');
                return redirect('/masyarakat/dashboard');
            }
        }
        alert()->error('Login Gagal', 'Email atau password salah.');
        return back()->withInput();
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
                    alert()->success('Login Berhasil', 'Selamat datang ' . $user->name . '!');
                    return redirect('/admin/dashboard');
                case 'psm':
                    alert()->success('Login Berhasil', 'Selamat datang ' . $user->name . '!');
                    return redirect('/psm/dashboard');
                case 'kasubag':
                    alert()->success('Login Berhasil', 'Selamat datang ' . $user->name . '!');
                    return redirect('/kasubag/dashboard');
                case 'operator':
                    alert()->success('Login Berhasil', 'Selamat datang ' . $user->name . '!');
                    return redirect('/operator/dashboard');
                default:
                    Auth::logout();
                    alert()->error('Login Gagal', 'Anda tidak memiliki akses.');
                    return back()->withInput();
            }
        }
        alert()->error('Login Gagal', 'Email atau password salah.');
        return back()->withInput();
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
            'alamat' => 'required',
            'nik' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => 'masyarakat', // Default role
        ]);

        alert()->success('Registrasi berhasil!', 'Silakan login.');
        return redirect()->route('login');
    }



    public function logout(Request $request)
    {
        $redirectPath = '/login';
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user->role, ['admin', 'psm', 'kasubag', 'operator'])) {
                $redirectPath = '/login-pegawai';
            }
        }

        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();
        alert()->success('Berhasil', 'Anda berhasil logout.');
        return redirect($redirectPath)->with('message', 'Anda berhasil logout.');
    }

}
