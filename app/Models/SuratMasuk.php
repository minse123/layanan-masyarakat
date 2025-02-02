<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal_terima', 'disposisi'];

    protected $table = 'surat_masuk';
    protected $primaryKey = 'id_masuk';

    public function masterSurat()
    {
        return $this->belongsTo(MasterSurat::class, 'id_surat');
    }
}
