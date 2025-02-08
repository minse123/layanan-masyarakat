<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiPending extends Model
{
    use HasFactory;
    protected $table = 'konsultasi_pending'; // Nama tabel jika berbeda dari konvensi
    protected $primaryKey = 'id_pending';

    protected $fillable = [
        'id_konsultasi',
        'tanggal_pengajuan',
    ];

    public function konsultasi()
    {
        return $this->belongsTo(MasterKonsultasi::class, 'id_konsultasi');
    }
}