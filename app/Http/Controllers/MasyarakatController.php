<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Video; // Tambahkan di bagian atas bersama use lain

class MasyarakatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        Log::info('Masyarakat dashboard accessed', [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'user_name' => $user?->name,
            'access_time' => now(),
        ]);

        // Ambil video yang sudah publish (ditampilkan = 1)
        $videos = Video::where('ditampilkan', 1)->latest()->take(4)->get();

        return view('masyarakat.dashboard', compact('videos'));
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
}
