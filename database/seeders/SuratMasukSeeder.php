<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data di master_surat
        DB::table('master_surat')->insertOrIgnore([
            ['id_surat' => 1],
            ['id_surat' => 2],
            ['id_surat' => 3],
        ]);

        DB::table('surat_masuk')->insert([
            [
                'id_surat' => 1,
                'tanggal_terima' => '2024-02-01',
                'disposisi' => 'Disposisi untuk surat pertama',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_surat' => 2,
                'tanggal_terima' => '2024-02-02',
                'disposisi' => 'Disposisi untuk surat kedua',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_surat' => 3,
                'tanggal_terima' => '2024-02-03',
                'disposisi' => 'Disposisi untuk surat ketiga',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
