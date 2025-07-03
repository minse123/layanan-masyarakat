<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSoalPelatihan extends Model
{
    protected $table = 'kategori_soal_pelatihan';

    protected $fillable = [
        'nama_kategori',
        'tipe',
    ];
}
