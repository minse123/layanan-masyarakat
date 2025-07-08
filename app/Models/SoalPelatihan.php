<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalPelatihan extends Model
{
    protected $table = 'soal_pelatihan';

    protected $fillable = [
        'id',
        'id_kategori_soal_pelatihan',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban_benar',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSoalPelatihan::class, 'id_kategori_soal_pelatihan');
    }
}
