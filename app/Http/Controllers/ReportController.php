<?php

namespace App\Http\Controllers;

use App\Models\MasterKonsultasi;
use App\Models\KategoriSoalPelatihan;
use App\Models\SoalPelatihan;
use App\Models\JawabanPeserta;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // Tambahkan ini jika pakai barryvdh/laravel-dompdf

class ReportController extends Controller
{

    private function applyPeriodeFilter($query, $request)
    {
        if ($request->filter == 'harian' && $request->tanggal) {
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
                $q->whereDate('tanggal_pengajuan', $request->tanggal);
            });
        } elseif ($request->filter == 'mingguan' && $request->minggu) {
            [$year, $week] = explode('-W', $request->minggu);
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($year, $week) {
                $q->whereRaw('YEAR(tanggal_pengajuan) = ? AND WEEK(tanggal_pengajuan, 1) = ?', [$year, $week]);
            });
        } elseif ($request->filter == 'bulanan' && $request->bulan) {
            [$year, $month] = explode('-', $request->bulan);
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($year, $month) {
                $q->whereYear('tanggal_pengajuan', $year)->whereMonth('tanggal_pengajuan', $month);
            });
        } elseif ($request->filter == 'tahunan' && $request->tahun) {
            $query->whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
                $q->whereYear('tanggal_pengajuan', $request->tahun);
            });
        }
    }
    // Report Konsultasi Pelatihan Inti
    public function reportInti(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_inti');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_inti', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        return view('report.konsultasi.inti', compact('data'));
    }

    public function cetakInti(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_inti');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_inti', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        $pdf = PDF::loadView('report.konsultasi.cetakinti', compact('data'));
        return $pdf->stream('laporan_konsultasi_pelatihan_inti.pdf');
    }

    // Report Konsultasi Pelatihan Pendukung
    public function reportPendukung(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_pendukung');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_pendukung', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        return view('report.konsultasi.pendukung', compact('data'));
    }

    public function cetakPendukung(Request $request)
    {
        $query = MasterKonsultasi::whereHas('kategoriPelatihan.jenisPelatihan', function ($q) use ($request) {
            $q->whereNotNull('pelatihan_pendukung');
            if ($request->jenis_pelatihan) {
                $q->where('pelatihan_pendukung', $request->jenis_pelatihan);
            }
        });

        $this->applyPeriodeFilter($query, $request);

        $data = $query->with([
            'kategoriPelatihan.jenisPelatihan',
            'jawabPelatihan'
        ])->get();

        $pdf = PDF::loadView('report.konsultasi.cetakpendukung', compact('data'));
        return $pdf->stream('laporan_konsultasi_pelatihan_pendukung.pdf');
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

    public function cetakStatistikTersulitPdf()
    {
        $soalStats = SoalPelatihan::select(
            'soal_pelatihan.id',
            'soal_pelatihan.pertanyaan',
            'kategori_soal_pelatihan.nama_kategori'
        )
            ->leftJoin('jawaban_peserta', 'soal_pelatihan.id', '=', 'jawaban_peserta.id_soal')
            ->leftJoin('kategori_soal_pelatihan', 'soal_pelatihan.id_kategori_soal_pelatihan', '=', 'kategori_soal_pelatihan.id')
            ->selectRaw('COUNT(jawaban_peserta.id) as total_attempts')
            ->selectRaw('SUM(CASE WHEN jawaban_peserta.benar = 0 THEN 1 ELSE 0 END) as incorrect_attempts')
            ->groupBy('soal_pelatihan.id', 'soal_pelatihan.pertanyaan', 'kategori_soal_pelatihan.nama_kategori')
            ->havingRaw('total_attempts > 0') // Only include questions that have been attempted
            ->orderByRaw('(SUM(CASE WHEN jawaban_peserta.benar = 0 THEN 1 ELSE 0 END) * 100.0 / COUNT(jawaban_peserta.id)) DESC')
            ->get();

        $pdf = Pdf::loadView('report.soal.report-statistik-tersulit-pdf', compact('soalStats'));
        return $pdf->stream('laporan-statistik-tersulit.pdf');
    }

    public function printVideo()
    {
        $videos = Video::all();
        $pdf = Pdf::loadView('report.video.report-video-pdf', compact('videos'));
        return $pdf->stream('laporan-video.pdf');
    }

}