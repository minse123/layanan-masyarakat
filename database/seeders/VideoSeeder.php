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
                'judul' => 'Pelatihan Pengelolaan BUMDes',
                'deskripsi' => 'Materi Pelatihan Pengelolaan BUMDes oleh Kemendes PDTT.',
                'youtube_id' => 'a_vMC-j_6Xw',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Bimbingan Teknis Pengelolaan Keuangan BUMDes',
                'deskripsi' => 'Bimbingan teknis tentang pengelolaan keuangan BUMDes.',
                'youtube_id' => 'L8X_xW2gqYc',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan Kader Pembangunan Manusia (KPM)',
                'deskripsi' => 'Pelatihan untuk Kader Pembangunan Manusia (KPM) dalam penanganan stunting.',
                'youtube_id' => 'YfPr-H_lO8c',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Webinar Nasional RUU Masyarakat Hukum Adat',
                'deskripsi' => 'Webinar tentang Rancangan Undang-Undang Masyarakat Hukum Adat.',
                'youtube_id' => 'B1b_v-zXpTE',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan Pembangunan Desa Wisata',
                'deskripsi' => 'Pelatihan membangun desa wisata untuk pertumbuhan ekonomi.',
                'youtube_id' => '4X-JkYt-v0s',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan Calon Transmigran',
                'deskripsi' => 'Pelatihan bagi calon transmigran di Balai Latihan Transmigrasi.',
                'youtube_id' => '5y2d-g7J2_s',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'inti',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pengembangan Produk Unggulan Kawasan Perdesaan (PRUKADES)',
                'deskripsi' => 'Sosialisasi dan workshop tentang PRUKADES.',
                'youtube_id' => 'Oa-l-y2i-qA',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'pendukung',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pelatihan E-commerce dan Digital Marketing',
                'deskripsi' => 'Pelatihan untuk UMKM mengenai e-commerce dan digital marketing.',
                'youtube_id' => 'J5aY-uU1k-A',
                'thumbnail_url' => null,
                'jenis_pelatihan' => 'pendukung',
                'ditampilkan' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
