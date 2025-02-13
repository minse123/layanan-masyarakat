<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    // Jika nama tabel di database berbeda dengan nama model (misal tabel 'tamu')
    protected $table = 'tamu';

    protected $primaryKey = 'id_tamu';

    // Kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'id_tamu',
        'nama',
        'telepon',
        'instansi',
        'alamat',
        'email',
        'keperluan',
        'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->date = now()->toDateString();
        });
    }
}

