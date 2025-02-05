<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterSurat;
use App\Models\SuratTolak;
use App\Models\SuratTerima;
use Carbon\Carbon;

class SuratProses extends Model
{
    use HasFactory;

    protected $table = 'surat_proses';
    protected $primaryKey = 'id_proses';

    protected $fillable = [
        'id_surat',
        'tanggal_proses',
        'catatan_proses',
    ];

    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratTolak::class, 'id_proses');
    }

    public function suratMasuk()
    {
        return $this->hasMany(SuratTerima::class, 'id_proses');
    }
}
