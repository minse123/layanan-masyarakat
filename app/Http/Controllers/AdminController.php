<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SuratProses;
use App\Models\SuratTerima;
use App\Models\SuratTolak;
use App\Models\MasterKonsultasi;
use App\Models\Video;
use App\Models\MasterSurat; // New: Import MasterSurat modelrt Log facade // Import MasterKonsultasi model
use RealRashid\SweetAlert\Facades\Alert;
use App\Imports\SoalImport;
use App\Exports\SoalExport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    protected string $layout;

    public function __construct()
    {
        $this->layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
        // default => 'layouts.default',
        };
    }

    public function index()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $totalSuratProses = SuratProses::count();
        $totalSuratTerima = SuratTerima::count();
        $totalSuratTolak = SuratTolak::count();
        $totalMasterSurat = MasterSurat::count(); // New: Total Master Surat
        $totalKonsultasi = MasterKonsultasi::count();
        $totalKonsultasiDijawab = MasterKonsultasi::where('status', 'Dijawab')->count();
        $totalKonsultasiPending = MasterKonsultasi::where('status', 'Pending')->count(); // Fixed: 'Pending'

        // Data for Charts
        $suratStatusData = MasterSurat::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();
        $konsultasiStatusData = MasterKonsultasi::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();

        // Data for Recent Activities
        $recentSurat = MasterSurat::orderBy('created_at', 'desc')->limit(5)->get();
        $recentKonsultasi = MasterKonsultasi::orderBy('created_at', 'desc')->limit(5)->get();

        $totalVideoPublish = Video::where('ditampilkan', 1)->count();
        $totalVideoBelumPublish = Video::where('ditampilkan', 0)->count();
        $totalVideos = Video::count(); // New: Total Videos
        $totalUsers = User::count(); // New: Total Users

        // Calculate active users
        $activeThreshold = Carbon::now()->subMinutes(5)->timestamp;
        $totalActiveUsers = DB::table('sessions')
            ->where('last_activity', '>=', $activeThreshold)
            ->whereNotNull('user_id') // Only count logged-in users
            ->count();

        return view('admin.dashboard.admin', compact(
            'layout',
            'totalSuratProses',
            'totalSuratTerima',
            'totalSuratTolak',
            'totalMasterSurat',
            'totalVideoPublish',
            'totalVideoBelumPublish',
            'totalVideos',
            'totalKonsultasi',
            'totalKonsultasiDijawab',
            'totalKonsultasiPending',
            'totalUsers',
            'totalActiveUsers',
            'suratStatusData',
            'konsultasiStatusData',
            'recentSurat',
            'recentKonsultasi'
        ));
    }

    public function authIndex()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        }; {
            $users = User::all(); // Mengambil semua data pengguna
            return view('admin.auth.index', compact('users','layout')); // Pastikan nama view benar
        }
    }
    public function authTambah()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $user = User::all();
        return view('admin.auth.auth-formTambah', compact('user', 'layout'));
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
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Disimpan');
    }
    public function authEdit($id)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $user = User::findOrFail($id);
        return view('admin.auth.auth-formEdit', compact('user', 'layout'));
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
            $user->password = Hash::make($request->password);
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


