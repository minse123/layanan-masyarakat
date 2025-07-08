<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSoalPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_soal_pelatihan')->insert([
            [
                'nama_kategori' => 'Bumdes',
                'tipe' => 'inti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'KPMD',
                'tipe' => 'inti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Masyarakat Hukum Adat',
                'tipe' => 'inti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Pembangunan Desa Wisata',
                'tipe' => 'inti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Catrans',
                'tipe' => 'inti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Pelatihan Perencanaan Pembangunan Partisipatif',
                'tipe' => 'inti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Prukades',
                'tipe' => 'pendukung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Prudes',
                'tipe' => 'pendukung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Ecomerce',
                'tipe' => 'pendukung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
