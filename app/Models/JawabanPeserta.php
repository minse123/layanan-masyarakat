<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPeserta extends Model
{
    protected $table = 'jawaban_peserta';

    protected $fillable = [
        'id_user',
        'id_soal',
        'jawaban_peserta',
        'benar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function soal()
    {
        return $this->belongsTo(SoalPelatihan::class, 'id_soal');
    }
}
