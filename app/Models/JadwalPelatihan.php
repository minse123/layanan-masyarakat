<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelatihan';

    protected $fillable = [
        'nama_pelatihan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'deskripsi',
        'pelatihan_inti',
        'pelatihan_pendukung',
        'file_path',
    ];
}