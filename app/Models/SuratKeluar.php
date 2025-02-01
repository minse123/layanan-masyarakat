<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $primaryKey = 'id_keluar';

    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }
}