<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSoalPelatihan extends Model
{
    protected $table = 'kategori_soal_pelatihan';

    protected $fillable = [
        'id',
        'nama_kategori',
        'tipe',
    ];

    public function soalPelatihan()
    {
        return $this->hasMany(SoalPelatihan::class, 'id_kategori_soal_pelatihan');
    }
}
