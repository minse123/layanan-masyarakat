<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuratSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            'Balikpapan',
            'Samarinda',
            'Banjarmasin',
            'Pontianak',
            'Palangkaraya',
            'Tarakan',
            'Banjarbaru',
            'Martapura',
            'Berau',
            'Singaraja',
            'Kutai Kartanegara',
            'Paser',
            'Kapuas',
            'Kotawaringin Barat',
            'Kotawaringin Timur',
            'Melawi',
            'Nunukan',
            'Sintang',
            'Tabalong',
            'Tanah Laut'
        ];

        $users = range(1, 10);
        $dataProses = [];
        $date = Carbon::now();

        foreach (range(0, 19) as $i) {
            $id_surat = DB::table('master_surat')->insertGetId([
                'nomor_surat' => 'MS-' . Str::random(5),
                'tanggal_surat' => $date->subDays(rand(1, 30))->format('Y-m-d'),
                'perihal' => 'Pengajuan proposal dari ' . $regions[$i],
                'pengirim' => 'Dinas ' . $regions[$i],
                'status' => 'Proses',
                'keterangan' => 'Surat dalam proses verifikasi',
                'id_user' => $users[array_rand($users)],
                'file_path' => 'uploads/surat/' . Str::random(10) . '.pdf',
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $dataProses[] = [
                'id_surat' => $id_surat,
                'tanggal_proses' => $date->subDays(rand(1, 10))->format('Y-m-d'),
                'catatan_proses' => 'Surat sedang dalam tahap pemeriksaan.',
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        DB::table('surat_proses')->insert($dataProses);
    }
}
