<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabPelatihan extends Model
{
    protected $table = 'jawab_konsultasi';
    protected $primaryKey = 'id_jawab';

    protected $fillable = [
        'id_konsultasi',
        'jawaban',
        'tanggal_dijawab',
    ];

    public function konsultasi()
    {
        return $this->belongsTo(MasterKonsultasi::class, 'id_konsultasi', 'id_konsultasi');
    }
}
