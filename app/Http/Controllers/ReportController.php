<?php

namespace App\Http\Controllers;

use App\Models\MasterKonsultasi;
use App\Models\KategoriSoalPelatihan;
use App\Models\SoalPelatihan;
use App\Models\JawabanPeserta;
use App\Models\User;
use App\Models\Video;
use App\Models\JadwalPelatihan;
use App\Models\MasterSurat;
use App\Models\SuratTerima;
use App\Models\SuratProses;
use App\Models\SuratTolak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // Tambahkan ini jika pakai barryvdh/laravel-dompdf
use Carbon\Carbon;

class ReportController extends Controller
{
    public function formReport()
    {
        // Ambil role user
        $role = auth()->user()->role;

        // Tentukan layout berdasarkan role
        $layout = match ($role) {
            'admin' => 'admin.app',
            'psm' => 'psm.app',
            'kasubag' => 'kasubag.app',
            default => 'layouts.default', // fallback
        };

        // Kirim ke view
        return view('report.form', compact('layout'));
    }
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
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
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

        return view('admin.report.konsultasi.inti', compact('data', 'layout'));
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

        $pdf = PDF::loadView('admin.report.konsultasi.cetakinti', compact('data'));
        return $pdf->stream('laporan_konsultasi_pelatihan_inti.pdf');
    }
    // Report Konsultasi Pelatihan Pendukung
    public function reportPendukung(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
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

        return view('admin.report.konsultasi.pendukung', compact('data', 'layout'));
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

        $pdf = PDF::loadView('admin.report.konsultasi.cetakpendukung', compact('data'));
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

        $pdf = Pdf::loadView('admin.report.soal.report-soal-pdf', compact('kategoriWithSoal'));
        return $pdf->stream('laporan-soal-pelatihan.pdf');
    }
    public function reportSoal(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $kategoriList = KategoriSoalPelatihan::orderBy('nama_kategori')->get();
        $soalQuery = SoalPelatihan::with('kategori');
        if ($request->filled('kategori')) {
            $soalQuery->where('id_kategori_soal_pelatihan', $request->kategori);
        }
        $soalList = $soalQuery->orderBy('id', 'desc')->get();

        return view('admin.report.soal.report-soal', compact('kategoriList', 'soalList', 'layout'));
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
        $pdf = Pdf::loadView('admin.report.soal.report-hasil-pdf', compact('user', 'kategori', 'soalPelatihan', 'jawabanPeserta', 'score'));
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

        $pdf = Pdf::loadView('admin.report.soal.report-rekap-pdf', compact('rekapData', 'kategoriList'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-rekap-nilai-keseluruhan.pdf');
    }
    public function reportRekapNilai(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $kategoriList = KategoriSoalPelatihan::all();
        $pesertaList = User::whereHas('jawabanPeserta')->get();
        $users = User::where('role', 'masyarakat')->get();
        $rekapList = collect();
        $selectedKategoriId = $request->input('kategori_id');

        $filteredKategoriList = $kategoriList;
        if ($selectedKategoriId) {
            $filteredKategoriList = $kategoriList->where('id', $selectedKategoriId);
        }

        foreach ($pesertaList as $peserta) {
            foreach ($filteredKategoriList as $kategori) {
                $soalIds = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategori->id)->pluck('id');

                if ($soalIds->isEmpty()) {
                    continue;
                }

                $jawaban = JawabanPeserta::where('id_user', $peserta->id)
                    ->whereIn('id_soal', $soalIds)
                    ->get();

                $jumlahSoal = $soalIds->count();
                $jumlahBenar = $jawaban->where('benar', 1)->count();
                $jumlahSalah = $jumlahSoal - $jumlahBenar;
                $skor = $jumlahSoal > 0 ? round(($jumlahBenar / $jumlahSoal) * 100) : 0;

                if ($jawaban->count() > 0) {
                    $rekapList->push((object) [
                        'id' => $peserta->id . '-' . $kategori->id, // Composite ID for reference
                        'user' => $peserta,
                        'kategori' => $kategori,
                        'total_soal' => $jumlahSoal,
                        'benar' => $jumlahBenar,
                        'salah' => $jumlahSalah,
                        'nilai' => $skor,
                        'created_at' => $jawaban->first()->created_at,
                    ]);
                }
            }
        }

        // Sort by created_at desc
        $rekapList = $rekapList->sortByDesc('created_at');

        return view('admin.report.soal.report-rekap', [
            'layout' => $layout,
            'rekapList' => $rekapList,
            'users' => $users,
            'kategoriList' => $kategoriList,
            'selectedKategoriId' => $selectedKategoriId
        ]);
    }
    public function reportHasilPeserta(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $kategoriList = KategoriSoalPelatihan::all();
        $pesertaList = User::whereHas('jawabanPeserta')->get();
        $users = User::where('role', 'masyarakat')->get();
        $rekapList = collect();
        $selectedKategoriId = $request->input('kategori_id');

        $filteredKategoriList = $kategoriList;
        if ($selectedKategoriId) {
            $filteredKategoriList = $kategoriList->where('id', $selectedKategoriId);
        }

        foreach ($pesertaList as $peserta) {
            foreach ($filteredKategoriList as $kategori) {
                $soalIds = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategori->id)->pluck('id');

                if ($soalIds->isEmpty()) {
                    continue;
                }

                $jawaban = JawabanPeserta::where('id_user', $peserta->id)
                    ->whereIn('id_soal', $soalIds)
                    ->get();

                $jumlahSoal = $soalIds->count();
                $jumlahBenar = $jawaban->where('benar', 1)->count();
                $jumlahSalah = $jumlahSoal - $jumlahBenar;
                $skor = $jumlahSoal > 0 ? round(($jumlahBenar / $jumlahSoal) * 100) : 0;

                if ($jawaban->count() > 0) {
                    $rekapList->push((object) [
                        'id' => $peserta->id . '-' . $kategori->id, // Composite ID for reference
                        'user' => $peserta,
                        'kategori' => $kategori,
                        'total_soal' => $jumlahSoal,
                        'benar' => $jumlahBenar,
                        'salah' => $jumlahSalah,
                        'nilai' => $skor,
                        'created_at' => $jawaban->first()->created_at,
                    ]);
                }
            }
        }

        // Sort by created_at desc
        $rekapList = $rekapList->sortByDesc('created_at');

        return view('admin.report.soal.report-hasil', [
            'layout' => $layout,
            'rekapList' => $rekapList,
            'users' => $users,
            'kategoriList' => $kategoriList,
            'selectedKategoriId' => $selectedKategoriId
        ]);
    }

    public function reportStatistik(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $kategoriId = $request->input('kategori');
        $limit = $request->input('limit', 10);
        $soal = SoalPelatihan::all();

        $query = SoalPelatihan::select([
            'soal_pelatihan.id',
            'soal_pelatihan.pertanyaan',
            'kategori_soal_pelatihan.nama_kategori',
            DB::raw('COUNT(jawaban_peserta.id) as total_jawaban'),
            DB::raw('SUM(CASE WHEN jawaban_peserta.benar = 0 THEN 1 ELSE 0 END) as total_salah'),
            DB::raw('ROUND((SUM(CASE WHEN jawaban_peserta.benar = 0 THEN 1 ELSE 0 END) / COUNT(jawaban_peserta.id)) * 100, 2) as persentase_salah')
        ])
            ->leftJoin('jawaban_peserta', 'soal_pelatihan.id', '=', 'jawaban_peserta.id_soal')
            ->leftJoin('kategori_soal_pelatihan', 'soal_pelatihan.id_kategori_soal_pelatihan', '=', 'kategori_soal_pelatihan.id')
            ->groupBy('soal_pelatihan.id', 'soal_pelatihan.pertanyaan', 'kategori_soal_pelatihan.nama_kategori')
            ->having('total_jawaban', '>', 0)
            ->orderBy('persentase_salah', 'DESC')
            ->orderBy('total_jawaban', 'DESC')
            ->limit($limit);

        if ($kategoriId) {
            $query->where('soal_pelatihan.id_kategori_soal_pelatihan', $kategoriId);
        }

        $soalTersulit = $query->get();
        $kategoriList = KategoriSoalPelatihan::all();

        return view('admin.soal.statistik-soal', [
            'layout' => $layout,
            'soal' => $soal,
            'soalTersulit' => $soalTersulit,
            'kategoriList' => $kategoriList,
            'selectedKategori' => $kategoriId,
            'limit' => $limit
        ]);
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

        $pdf = Pdf::loadView('admin.report.soal.report-statistik-tersulit-pdf', compact('soalStats'));
        return $pdf->stream('laporan-statistik-tersulit.pdf');
    }

    public function reportVideo(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $query = Video::latest();

        if ($request->filled('jenis_pelatihan')) {
            $query->where('jenis_pelatihan', $request->jenis_pelatihan);
        }

        $videos = $query->get();

        return view('admin.report.configuration.report-video', compact('videos', 'layout'));
    }

    public function printVideo(Request $request)
    {
        $query = Video::query();

        if ($request->filled('jenis_pelatihan')) {
            $query->where('jenis_pelatihan', $request->jenis_pelatihan);
        }

        $videos = $query->get();
        $pdf = Pdf::loadView('admin.report.configuration.report-video-pdf', compact('videos'));
        return $pdf->stream('laporan-video.pdf');
    }

    public function jadwalPelatihan(Request $request)
    {
        $query = JadwalPelatihan::query();

        if ($request->has('jenis_pelatihan') && $request->jenis_pelatihan != '') {
            $jenis_pelatihan = $request->jenis_pelatihan;
            $parts = explode('_', $jenis_pelatihan, 2);
            if (count($parts) == 2) {
                $type = $parts[0];
                $value = $parts[1];
                if ($type === 'inti') {
                    $query->where('pelatihan_inti', $value);
                } elseif ($type === 'pendukung') {
                    $query->where('pelatihan_pendukung', $value);
                }
            }
        }

        $data = $query->get();
        $pdf = PDF::loadView('admin.report.configuration.report-jadwal-pelatihan-pdf', compact('data'));
        return $pdf->stream('laporan-jadwal-pelatihan.pdf');
    }
    public function reportJadwalPelatihan(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $query = JadwalPelatihan::query();

        if ($request->has('jenis_pelatihan') && $request->jenis_pelatihan != '') {
            $jenis_pelatihan = $request->jenis_pelatihan;
            $parts = explode('_', $jenis_pelatihan, 2);
            if (count($parts) == 2) {
                $type = $parts[0];
                $value = $parts[1];
                if ($type === 'inti') {
                    $query->where('pelatihan_inti', $value);
                } elseif ($type === 'pendukung') {
                    $query->where('pelatihan_pendukung', $value);
                }
            }
        }

        $data = $query->get();
        return view('admin.report.configuration.report-jadwal-pelatihan', compact('data', 'layout'));
    }

    // Report Surat Masuk, Surat Diterima, Surat ditolak
    public function report(Request $request, $type)
    {
        $config = $this->getReportConfig($type);
        if (!$config) {
            abort(404);
        }

        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };

        $filter = $request->input('filter');
        $tanggal = $request->input('tanggal');

        $model = $config['model'];
        $dateColumn = $config['date_column'];

        $query = $model::query()->with('masterSurat');

        $this->applyDateFilter($query, $dateColumn, $filter, $tanggal);

        $data = $query->get();

        if ($filter && $tanggal) {
            session(['filter' => $filter, 'tanggal' => $tanggal]);
        }

        $message = '';
        if ($data->isEmpty() && $filter) {
            $message = 'Tidak ada data yang ditemukan untuk filter yang dipilih.';
        }

        return view($config['view'], compact('data', 'layout', 'message', 'type'));
    }

    public function cetakReport(Request $request, $type)
    {
        $config = $this->getReportConfig($type);
        if (!$config) {
            abort(404);
        }

        $filter = session('filter');
        $tanggal = session('tanggal');

        $model = $config['model'];
        $dateColumn = $config['date_column'];

        $query = $model::query()->with('masterSurat');

        $this->applyDateFilter($query, $dateColumn, $filter, $tanggal);

        $data = $query->get();

        $pdf = PDF::loadView($config['pdf_view'], compact('data', 'filter', 'tanggal'));
        return $pdf->stream($config['pdf_filename']);
    }

    public function resetReport(Request $request, $type)
    {
        $request->session()->forget(['filter', 'tanggal']);
        return redirect()->route('admin.surat.report', ['type' => $type]);
    }

    private function getReportConfig($type)
    {
        $configs = [
            'proses' => [
                'model' => SuratProses::class,
                'date_column' => 'tanggal_proses',
                'view' => 'admin.report.surat.reportproses',
                'pdf_view' => 'admin.report.surat.formCetakProses',
                'reset_route' => 'admin.surat.report',
                'pdf_filename' => 'laporan-surat-masuk.pdf',
            ],
            'terima' => [
                'model' => SuratTerima::class,
                'date_column' => 'tanggal_terima',
                'view' => 'admin.report.surat.reportterima',
                'pdf_view' => 'admin.report.surat.formCetakTerima',
                'reset_route' => 'admin.surat.report',
                'pdf_filename' => 'laporan-surat-diterima.pdf',
            ],
            'tolak' => [
                'model' => SuratTolak::class,
                'date_column' => 'tanggal_tolak',
                'view' => 'admin.report.surat.reporttolak',
                'pdf_view' => 'admin.report.surat.formCetakTolak',
                'reset_route' => 'admin.surat.report',
                'pdf_filename' => 'laporan-surat-ditolak.pdf',
            ],
        ];

        return $configs[$type] ?? null;
    }
    private function applyDateFilter($query, $dateColumn, $filter, $date)
    {
        if ($filter && $date) {
            if ($filter === 'tahunan') {
                $query->whereYear($dateColumn, $date);
                return $query;
            }

            $carbonDate = Carbon::parse($date);
            switch ($filter) {
                case 'harian':
                    $query->whereDate($dateColumn, $carbonDate);
                    break;
                case 'mingguan':
                    $query->whereBetween($dateColumn, [$carbonDate->startOfWeek(), $carbonDate->endOfWeek()]);
                    break;
                case 'bulanan':
                    $query->whereMonth($dateColumn, $carbonDate->month)
                        ->whereYear($dateColumn, $carbonDate->year);
                    break;
            }
        }
        return $query;
    }


}