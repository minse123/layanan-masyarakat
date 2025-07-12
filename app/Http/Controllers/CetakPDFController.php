<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\MasterKonsultasi; // Model for consultations
use App\Models\KonsultasiPending; // Model for pending consultations
use App\Models\KonsultasiDijawab; // Model for answered consultations
use App\Models\SuratTerima;
use App\Models\SuratProses;
use App\Models\SuratTolak;
use App\Models\MasterSurat;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\KategoriSoalPelatihan;
use App\Models\User;
use App\Models\SoalPelatihan;
use App\Models\JawabanPeserta;
use App\Models\HasilPelatihan;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakPDFController extends Controller
{
    public function tamucetakPDF(Request $request)
    {
        // ... existing code ...
    }

    public function cetakSoalPdf(Request $request)
    {
        $request->validate([
            'kategori_ids' => 'required|array|min:1',
            'kategori_ids.*' => 'exists:kategori_soal_pelatihan,id',
        ]);

        $kategoriWithSoal = KategoriSoalPelatihan::with('soalPelatihan')
            ->whereIn('id', $request->kategori_ids)
            ->get();

        $pdf = Pdf::loadView('report.soal.report-soal-pdf', compact('kategoriWithSoal'));
        return $pdf->stream('laporan-soal-pelatihan.pdf');
    }

    public function cetakHasilPdf(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_id' => 'required|exists:kategori_soal_pelatihan,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $kategori = KategoriSoalPelatihan::findOrFail($request->kategori_id);

        // Fetch questions, participant's answers, and correct answers
        $soalPelatihan = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategori->id)->get();
        $jawabanPeserta = JawabanPeserta::where('id_user', $user->id)
                                        ->whereIn('id_soal', $soalPelatihan->pluck('id'))
                                        ->get()
                                        ->keyBy('id_soal');

        // Calculate score
        $correctAnswers = 0;
        foreach ($soalPelatihan as $soal) {
            if (isset($jawabanPeserta[$soal->id]) && $jawabanPeserta[$soal->id]->jawaban_peserta == $soal->jawaban_benar) {
                $correctAnswers++;
            }
        }
        $totalQuestions = $soalPelatihan->count();
        $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

        // Load PDF view
        $pdf = Pdf::loadView('report.soal.report-hasil-pdf', compact('user', 'kategori', 'soalPelatihan', 'jawabanPeserta', 'score'));
        return $pdf->stream('laporan-hasil-pelatihan-' . $user->name . '-' . $kategori->nama_kategori . '.pdf');
    }

    public function cetakRekapNilaiPdf()
    {
        $kategoriList = KategoriSoalPelatihan::all();
        $users = User::where('role', 'masyarakat')->get(); // Get all users with role 'masyarakat'

        $rekapData = [];

        foreach ($users as $user) {
            $userScores = [
                'user' => $user,
                'scores' => [],
                'total_correct' => 0,
                'total_questions' => 0,
                'overall_score' => 0,
            ];

            foreach ($kategoriList as $kategori) {
                $soalIds = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategori->id)->pluck('id');

                if ($soalIds->isEmpty()) {
                    $userScores['scores'][$kategori->nama_kategori] = [
                        'total_soal' => 0,
                        'benar' => 0,
                        'salah' => 0,
                        'nilai' => 0,
                    ];
                    continue;
                }

                $jawaban = JawabanPeserta::where('id_user', $user->id)
                    ->whereIn('id_soal', $soalIds)
                    ->get();

                $jumlahBenar = 0;
                foreach ($jawaban as $jwb) {
                    $soal = SoalPelatihan::find($jwb->id_soal);
                    if ($soal && $jwb->jawaban_peserta == $soal->jawaban_benar) {
                        $jumlahBenar++;
                    }
                }
                $jumlahSoal = $soalIds->count();
                $jumlahSalah = $jumlahSoal - $jumlahBenar;
                $skor = $jumlahSoal > 0 ? round(($jumlahBenar / $jumlahSoal) * 100) : 0;

                $userScores['scores'][$kategori->nama_kategori] = [
                    'total_soal' => $jumlahSoal,
                    'benar' => $jumlahBenar,
                    'salah' => $jumlahSalah,
                    'nilai' => $skor,
                ];

                $userScores['total_correct'] += $jumlahBenar;
                $userScores['total_questions'] += $jumlahSoal;
            }

            $userScores['overall_score'] = ($userScores['total_questions'] > 0) ?
                round(($userScores['total_correct'] / $userScores['total_questions']) * 100) : 0;

            $rekapData[] = (object) $userScores;
        }

        $pdf = Pdf::loadView('report.soal.report-rekap-pdf', compact('rekapData', 'kategoriList'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-rekap-nilai-keseluruhan.pdf');
    }
}