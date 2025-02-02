<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSurat extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_surat', 'tanggal_surat', 'pengirim', 'perihal'];

    protected $table = 'master_surat';
    protected $primaryKey = 'id_surat';

    public function suratMasuk()
    {
        return $this->hasOne(SuratMasuk::class, 'id_surat');
    }

    public function suratProses()
    {
        return $this->hasOne(SuratProses::class, 'id_surat');
    }

    public function suratKeluar()
    {
        return $this->hasOne(SuratKeluar::class, 'id_surat');
    }
}