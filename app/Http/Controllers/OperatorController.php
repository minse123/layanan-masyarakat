<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Video;
use App\Models\User;
use App\Models\JadwalPelatihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OperatorController extends Controller
{
    public function operatorIndex()
    {
        $layout = match (auth()->user()->role) {
            'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };

        // Video statistics
        $totalVideos = Video::count();
        $totalVideoPublish = Video::where('ditampilkan', 1)->count();
        $totalVideoBelumPublish = Video::where('ditampilkan', 0)->count();

        // Jadwal Pelatihan statistics
        $totalJadwal = JadwalPelatihan::count();
        $jadwalTerlaksana = JadwalPelatihan::where('tanggal_selesai', '<', now())->count();
        $jadwalBelumTerlaksana = JadwalPelatihan::where('tanggal_selesai', '>=', now())->orWhereNull('tanggal_selesai')->count();

        // Data for Charts
        $videoStatusData = [
            'Publish' => $totalVideoPublish,
            'Belum Publish' => $totalVideoBelumPublish,
        ];

        $jadwalStatusData = [
            'Terlaksana' => $jadwalTerlaksana,
            'Belum Terlaksana' => $jadwalBelumTerlaksana,
        ];

        // Recent Activities
        $recentVideos = Video::orderBy('created_at', 'desc')->limit(5)->get();
        $upcomingJadwals = JadwalPelatihan::where('tanggal_mulai', '>', now())->orderBy('tanggal_mulai', 'asc')->limit(5)->get();

        return view('admin.dashboard.operator', compact(
            'layout',
            'totalVideos',
            'totalVideoPublish',
            'totalVideoBelumPublish',
            'totalJadwal',
            'jadwalTerlaksana',
            'jadwalBelumTerlaksana',
            'videoStatusData',
            'jadwalStatusData',
            'recentVideos',
            'upcomingJadwals'
        ));
    }
}
