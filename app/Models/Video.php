<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    use HasFactory;

    protected $table = 'video_pelatihan';
    // protected $primaryKey = 'id_video';
    public $incrementing = true; // ID auto-increment
    protected $keyType = 'int';
    protected $fillable = [
        'judul',
        'deskripsi',
        'youtube_id',
        'thumbnail_url',
        'ditampilkan',
    ];

    
}
