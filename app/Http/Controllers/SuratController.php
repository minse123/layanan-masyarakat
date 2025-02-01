<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;

class SuratController extends Controller
{
    public function Masukindex(
    ) {
        $data = SuratMasuk::with('masterSurat')->get();
        // dd($data);
        return view('admin.surat.masuk.index', compact('data'));
    }
}
