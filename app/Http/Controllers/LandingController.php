<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPelatihan;
use App\Models\Video;

class LandingController extends Controller
{
    public function landing()
    {
        $jadwalPelatihan = JadwalPelatihan::latest()->take(4)->get();
        $videos = Video::latest()->take(4)->get();
        return view('landing', compact('jadwalPelatihan', 'videos'));
    }

    
}
