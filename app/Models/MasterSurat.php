<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SuratTolak;
use App\Models\SuratTerima;
use App\Models\SuratProses;
// use Carbon\Carbon;
class MasterSurat extends Model
{
    use HasFactory;
    protected $table = 'master_surat';
    protected $primaryKey = 'id_surat';
    public $incrementing = true; // ID auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'id_surat',
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'pengirim',
        'telepon',
        'keterangan',
        'file_path',
        'status',
        'id_user',
    ];

    public function suratTerima()
    {
        return $this->hasMany(SuratTerima::class, 'id_surat');
    }

    public function suratProses()
    {
        return $this->hasMany(SuratProses::class, 'id_surat');
    }

    public function suratTolak()
    {
        return $this->hasMany(SuratTolak::class, 'id_surat');
    }
}