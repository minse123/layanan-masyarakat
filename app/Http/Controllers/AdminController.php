<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SuratProses;
use App\Models\SuratTerima;
use App\Models\SuratTolak;
use App\Models\MasterKonsultasi;
use App\Models\Video;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{

    public function index()
    {
        $totalSuratProses = SuratProses::count();
        $totalSuratTerima = SuratTerima::count();
        $totalSuratTolak = SuratTolak::count();
        $totalKonsultasi = MasterKonsultasi::count();
        $totalKonsultasiDijawab = MasterKonsultasi::where('status', 'Dijawab')->count();
        $totalKonsultasiPending = MasterKonsultasi::where('status', 'Belum Dijawab')->count();
        $totalVideoPublish = Video::where('ditampilkan', 1)->count();
        $totalVideoBelumPublish = Video::where('ditampilkan', 0)->count();

        return view('admin.dashboard', compact(
            'totalSuratProses',
            'totalSuratTerima',
            'totalSuratTolak',
            'totalVideoPublish',
            'totalVideoBelumPublish',
            'totalKonsultasi',
            'totalKonsultasiDijawab',
            'totalKonsultasiPending', // <-- ini yang benar
        ));
    }
    public function authIndex()
    { {
            $users = User::all(); // Mengambil semua data pengguna
            return view('admin.auth.index', compact('users')); // Pastikan nama view benar
        }
    }
    public function authTambah()
    {
        $user = User::all();
        return view('admin.auth.auth-formTambah');
    }
    public function authSimpan(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->role = $request->role;
        $user->password = $request->password;
        $user->save();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Disimpan');
    }
    public function authEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.auth.auth-formEdit', compact('user'));
    }
    public function authUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = $request->password; // tanpa bcrypt
        }

        $user->save();

        // Menggunakan SweetAlert bawaan Laravel (laravel-sweetalert)
        Alert::success('Berhasil', 'Data berhasil disimpan!');
        return redirect()->route('admin.akun')->with('success', 'Data berhasil disimpan!');
    }
    public function authHapus(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Dihapus');
    }



}


