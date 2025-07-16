<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SoalExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            [
                'id_kategori_soal_pelatihan' => '1',
                'pertanyaan' => 'Contoh pertanyaan 1?',
                'pilihan_a' => 'Pilihan A',
                'pilihan_b' => 'Pilihan B',
                'pilihan_c' => 'Pilihan C',
                'pilihan_d' => 'Pilihan D',
                'jawaban_benar' => 'a',
            ],
            [
                'id_kategori_soal_pelatihan' => '2',
                'pertanyaan' => 'Contoh pertanyaan 2?',
                'pilihan_a' => 'Pilihan A',
                'pilihan_b' => 'Pilihan B',
                'pilihan_c' => 'Pilihan C',
                'pilihan_d' => 'Pilihan D',
                'jawaban_benar' => 'b',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'id_kategori_soal_pelatihan',
            'pertanyaan',
            'pilihan_a',
            'pilihan_b',
            'pilihan_c',
            'pilihan_d',
            'jawaban_benar',
        ];
    }
}
