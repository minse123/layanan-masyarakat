<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterSurat;
use App\Models\SuratProses;

class SuratTolak extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_surat',
        'id_proses',
        'tanggal_tolak',
        'catatan_tolak',
    ];
    protected $table = 'surat_tolak';
    protected $primaryKey = 'id_tolak';

    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }

    public function SuratProses()
    {
        return $this->belongsTo(SuratProses::class, 'id_proses');
    }
}
