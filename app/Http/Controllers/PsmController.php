<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKonsultasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class PsmController extends Controller
{
    public function index()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $totalKonsultasi = MasterKonsultasi::count();
        $totalKonsultasiPending = MasterKonsultasi::where('status', 'Pending')->count();
        $totalKonsultasiDijawab = MasterKonsultasi::where('status', 'Dijawab')->count();

        // Data for Charts
        $konsultasiStatusData = MasterKonsultasi::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();

        // Data for Recent Activities
        $recentKonsultasi = MasterKonsultasi::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.psm', compact(
            'layout',
            'totalKonsultasi',
            'totalKonsultasiPending',
            'totalKonsultasiDijawab',
            'konsultasiStatusData',
            'recentKonsultasi'
        ));
    }
    public function updateProfile(Request $request)
    {
        \Log::info('Route hit: ' . $request->path());
        \Log::info('Method: ' . $request->method());
        \Log::info('User authenticated: ' . (Auth::check() ? 'Yes' : 'No'));
        \Log::info('Update Profile Called', [
            'user_id' => Auth::id(),
            'is_authenticated' => Auth::check(),
            'request_data' => $request->all()
        ]);

        if (!Auth::check()) {
            \Log::error('User not authenticated in updateProfile');
            return redirect()->route('login');
        }
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