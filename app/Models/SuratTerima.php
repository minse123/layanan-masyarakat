<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MasterSurat;
use App\Models\SuratProses;

class SuratTerima extends Model
{
    use HasFactory;
    protected $table = 'surat_terima';
    protected $primaryKey = 'id_terima';
    public $incrementing = true; // ID auto-increment
    protected $keyType = 'int';
    protected $fillable = [
        'id_surat',
        // 'id_proses',
        'tanggal_terima',
        'catatan_terima',
    ];

    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }
    // public function suratProses()
    // {
    //     return $this->belongsTo(SuratProses::class, 'id_proses');
    // }
}