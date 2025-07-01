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
        'id_user',
        'nama',
        'telepon',
        'email',
        'judul_konsultasi',
        'deskripsi',
        'status',
    ];

    public function kategoriPelatihan()
    {
        return $this->hasOne(KategoriPelatihan::class, 'id_konsultasi', 'id_konsultasi');
    }

    public function jawabPelatihan()
    {
        return $this->hasOne(\App\Models\JawabPelatihan::class, 'id_konsultasi', 'id_konsultasi');
    }
}