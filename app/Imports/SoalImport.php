<?php

namespace App\Imports;

use App\Models\SoalPelatihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoalImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SoalPelatihan([
            'id_kategori_soal_pelatihan' => $row['id_kategori_soal_pelatihan'],
            'pertanyaan' => $row['pertanyaan'],
            'pilihan_a' => $row['pilihan_a'],
            'pilihan_b' => $row['pilihan_b'],
            'pilihan_c' => $row['pilihan_c'],
            'pilihan_d' => $row['pilihan_d'],
            'jawaban_benar' => $row['jawaban_benar'],
        ]);
    }
}
