<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JawabanPeserta;
use App\Models\SoalPelatihan;
use Illuminate\Support\Facades\Auth;

class JawabanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|string',
        ]);

        $userId = Auth::id();

        foreach ($request->jawaban as $soal_id => $jawaban) {
            $soal = SoalPelatihan::find($soal_id);
            $isBenar = ($soal && $soal->kunci_jawaban == $jawaban) ? 1 : 0;
        
            JawabanPeserta::updateOrCreate(
                ['id_user' => $userId, 'id_soal' => $soal_id],
                ['jawaban' => $jawaban, 'benar' => $isBenar]
            );
        }

        return redirect()->route('masyarakat.soal.hasil')->with('success', 'Jawaban berhasil disimpan!');
    }
}