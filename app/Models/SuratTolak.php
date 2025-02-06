<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterSurat;
use App\Models\SuratProses;

class SuratTolak extends Model
{
    use HasFactory;
    protected $table = 'surat_tolak';
    protected $primaryKey = 'id_tolak';
    protected $fillable = [
        'id_surat',
        'id_proses',
        'tanggal_tolak',
        'alasan_tolak',
    ];
    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }

    public function suratProses()
    {
        return $this->belongsTo(SuratProses::class, 'id_proses');
    }
}
