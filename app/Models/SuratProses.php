<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratProses extends Model
{
    use HasFactory;

    protected $table = 'surat_proses';
    protected $primaryKey = 'id_proses';

    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }
}