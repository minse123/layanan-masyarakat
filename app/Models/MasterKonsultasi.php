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

    // Jika satu konsultasi bisa punya banyak kategori pelatihan
    public function kategoriPelatihan()
    {
        return $this->hasMany(KategoriPelatihan::class, 'id_konsultasi', 'id_konsultasi');
    }

    // Jika satu konsultasi hanya punya satu jawaban
    public function jawabPelatihan()
    {
        return $this->hasOne(JawabPelatihan::class, 'id_konsultasi', 'id_konsultasi');
    }
}