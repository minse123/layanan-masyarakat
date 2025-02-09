<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiDijawab extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_dijawab';

    protected $table = 'konsultasi_dijawab'; // Nama tabel jika berbeda dari konvensi
    protected $fillable = [
        'id_konsultasi',
        'jawaban',
        'tanggal_dijawab',
    ];

    public function masterKonsultasi()
    {
        return $this->belongsTo(MasterKonsultasi::class, 'id_konsultasi');
    }
}