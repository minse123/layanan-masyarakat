<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPelatihan extends Model
{
    protected $table = 'kategori_pelatihan';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'id_konsultasi',
        'jenis_kategori',
        
    ];
    protected $guarded = [];

    public function konsultasi()
    {
        return $this->belongsTo(MasterKonsultasi::class, 'id_konsultasi', 'id_konsultasi');
    }

    public function jenisPelatihan()
    {
        return $this->hasOne(JenisPelatihan::class, 'id_kategori', 'id_kategori');
    }

    public function jawabPelatihan()
    {
        return $this->hasOne(JawabPelatihan::class, 'id_konsultasi', 'id_konsultasi');
    }
}
