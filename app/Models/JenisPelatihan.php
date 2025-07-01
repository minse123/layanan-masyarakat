<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelatihan extends Model
{
    protected $table = 'jenis_pelatihan';
    protected $primaryKey = 'id_pelatihan';

    protected $fillable = [
        'id_kategori',
        'pelatihan_inti',
        'tanggal_pengajuan',
        'pelatihan_pendukung',
    ];

    public function kategoriPelatihan()
    {
        return $this->belongsTo(KategoriPelatihan::class, 'id_kategori', 'id_kategori');
    }
}
