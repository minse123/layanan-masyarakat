<?php

namespace App\Http\Controllers\SoalController;

use App\Models\SoalPelatihan;
use App\Models\JawabanPeserta;
use App\Models\KategoriSoalPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikSoalController
{
    public function index(Request $request)
    {
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
            'soal' => $soal,
            'soalTersulit' => $soalTersulit,
            'kategoriList' => $kategoriList,
            'selectedKategori' => $kategoriId,
            'limit' => $limit
        ]);
    }

    
    

    
}
