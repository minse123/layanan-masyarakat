<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'master_konsultasi'; // Nama tabel jika berbeda dari konvensi
    protected $primaryKey = 'id_konsultasi';
    public $incrementing = true; // ID auto-increment
    protected $keyType = 'int';
    protected $fillable = [
        'id_konsultasi',
        'nama',
        'telepon',
        'email',
        'judul_konsultasi',
        'deskripsi',
        'status',
    ];

    public function konsultasiPending()
    {
        return $this->hasMany(KonsultasiPending::class, 'id_konsultasi');
    }

    public function konsultasiDijawab()
    {
        return $this->hasOne(KonsultasiDijawab::class, 'id_konsultasi')->withDefault();
    }
}