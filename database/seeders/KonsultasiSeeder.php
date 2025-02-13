<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KonsultasiSeeder extends Seeder
{
    public function run()
    {
        $names = [
            'Bahrun',
            'Jatmiko',
            'Suryadi',
            'Iskandar',
            'Syahrani',
            'Muslimin',
            'Halimah',
            'Rizky',
            'Junaidi',
            'Siti Aisyah',
            'Rahmad',
            'Herlina',
            'Abdullah',
            'Mulyadi',
            'Rafidah',
            'Zulkifli',
            'Hasanuddin',
            'Darmadi',
            'Fatimah',
            'Nasrullah'
        ];

        $emails = array_map(fn($name) => strtolower(Str::slug($name)) . '@example.com', $names);
        $phones = array_map(fn() => '08' . rand(1111111111, 9999999999), range(1, 20));
        $topics = [
            'Pendirian BUMDes',
            'Perizinan Usaha Desa',
            'Keuangan BUMDes',
            'Kerjasama BUMDes',
            'Pelatihan SDM',
            'Pengelolaan Aset Desa',
            'Strategi Pemasaran',
            'Digitalisasi BUMDes',
            'Modal dan Investasi',
            'Manajemen Risiko',
            'Pengembangan Produk Lokal',
            'Hukum dan Regulasi',
            'Kemitraan dengan Swasta',
            'Pengelolaan Pariwisata Desa',
            'E-commerce Desa',
            'Subsidi Pemerintah',
            'Pajak dan Retribusi',
            'Evaluasi Kinerja BUMDes',
            'Program CSR',
            'Peningkatan Daya Saing'
        ];

        $data = [];
        $pendingData = [];
        $date = Carbon::now();

        foreach (range(0, 19) as $i) {
            $id_konsultasi = DB::table('master_konsultasi')->insertGetId([
                'nama' => $names[$i],
                'telepon' => $phones[$i],
                'email' => $emails[$i],
                'judul_konsultasi' => $topics[$i],
                'deskripsi' => 'Saya ingin mendapatkan informasi lebih lanjut tentang ' . strtolower($topics[$i]) . '.',
                'status' => 'Pending',
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $pendingData[] = [
                'id_konsultasi' => $id_konsultasi,
                'tanggal_pengajuan' => $date->subDays(rand(1, 30))->format('Y-m-d'),
                'created_at' => $date,
                'updated_at' => $date,
            ];
        }

        DB::table('konsultasi_pending')->insert($pendingData);
    }
}
