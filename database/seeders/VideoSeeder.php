<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('video_pelatihan')->insert([
            [
                'judul' => 'Pelatihan Dasar Laravel',
                'deskripsi' => 'Belajar dasar framework Laravel untuk pemula.',
                'youtube_id' => 'mYF7T2bP6gk',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Membuat CRUD dengan Laravel',
                'deskripsi' => 'Tutorial CRUD sederhana menggunakan Laravel.',
                'youtube_id' => 'Z1RJmh_OqeA',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Dasar HTML untuk Pemula',
                'deskripsi' => 'Pengenalan HTML untuk membangun website.',
                'youtube_id' => 'UB1O30fR-EE',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'pendukung',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'CSS Dasar dan Layouting',
                'deskripsi' => 'Belajar CSS untuk mempercantik tampilan web.',
                'youtube_id' => 'yfoY53QXEnI',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'pendukung',
                'ditampilkan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Belajar Bootstrap 4',
                'deskripsi' => 'Membuat tampilan responsif dengan Bootstrap.',
                'youtube_id' => '5GcQtLDGXy8',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'pendukung',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pengenalan Database MySQL',
                'deskripsi' => 'Dasar-dasar penggunaan MySQL untuk aplikasi web.',
                'youtube_id' => '9ylj9NR0Lcg',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'REST API dengan Laravel',
                'deskripsi' => 'Membuat REST API sederhana menggunakan Laravel.',
                'youtube_id' => 'MFh0Fd7BsjE',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Validasi Form di Laravel',
                'deskripsi' => 'Cara melakukan validasi form pada Laravel.',
                'youtube_id' => 'p8C2O5vY8lY',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Belajar Git Dasar',
                'deskripsi' => 'Pengenalan penggunaan Git untuk version control.',
                'youtube_id' => 'SWYqp7iY_Tc',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'pendukung',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Deploy Laravel ke Hosting',
                'deskripsi' => 'Panduan deploy aplikasi Laravel ke shared hosting.',
                'youtube_id' => '2LSMpuQcTSE',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
