<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPelatihan extends Model
{
    protected $table = 'hasil_pelatihan';

    protected $fillable = [
        'id_user',
        'id_kategori_soal_pelatihan',
        'total_soal',
        'benar',
        'salah',
        'nilai',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke KategoriSoalPelatihan
    public function kategori()
    {
        return $this->belongsTo(KategoriSoalPelatihan::class, 'id_kategori_soal_pelatihan');
    }
}
