<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\KonsultasiPending;
use App\Models\KonsultasiDijawab;
use App\Models\SuratProses;
use App\Models\SuratTerima;
use App\Models\SuratTolak;
use App\Models\MasterSurat;
use App\Models\MasterKonsultasi;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade

class KasubagController extends Controller
{
    public function index()
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $totalSuratProses = SuratProses::count();
        $totalSuratTerima = SuratTerima::count();
        $totalSuratTolak = SuratTolak::count();
        $totalMasterSurat = MasterSurat::count();

        return view('admin.dashboard.kasubag', compact(
            'layout',
            'totalSuratProses',
            'totalSuratTerima',
            'totalSuratTolak',
            'totalMasterSurat',
        ));
    }

    
}