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
            'Bahrun', 'Jatmiko', 'Suryadi', 'Iskandar', 'Syahrani',
            'Muslimin', 'Halimah', 'Rizky', 'Junaidi', 'Siti Aisyah',
            'Rahmad', 'Herlina', 'Abdullah', 'Mulyadi', 'Rafidah',
            'Zulkifli', 'Hasanuddin', 'Darmadi', 'Fatimah', 'Nasrullah'
        ];

        $emails = array_map(fn($name) => strtolower(Str::slug($name)) . '@example.com', $names);
        $phones = array_map(fn() => '08' . rand(1111111111, 9999999999), range(1, 20));
        $topics = [
            'Pendirian BUMDes', 'Perizinan Usaha Desa', 'Keuangan BUMDes', 'Kerjasama BUMDes', 'Pelatihan SDM',
            'Pengelolaan Aset Desa', 'Strategi Pemasaran', 'Digitalisasi BUMDes', 'Modal dan Investasi', 'Manajemen Risiko',
            'Pengembangan Produk Lokal', 'Hukum dan Regulasi', 'Kemitraan dengan Swasta', 'Pengelolaan Pariwisata Desa',
            'E-commerce Desa', 'Subsidi Pemerintah', 'Pajak dan Retribusi', 'Evaluasi Kinerja BUMDes', 'Program CSR', 'Peningkatan Daya Saing'
        ];

        $kategoriList = ['inti', 'pendukung'];
        $pelatihanInti = [
            'bumdes', 'kpmd', 'masyarakat_hukum_adat', 'pembangunan_desa_wisata', 'catrans', 'pelatihan_perencanaan_pembangunan_partisipatif'
        ];
        $pelatihanPendukung = [
            'prukades', 'prudes', 'ecomerce'
        ];

        $date = Carbon::now();

        foreach (range(0, 19) as $i) {
            // 1. Insert ke master_konsultasi
            $status = rand(0, 1) ? 'Pending' : 'Dijawab';
            $id_konsultasi = DB::table('master_konsultasi')->insertGetId([
                'nama' => $names[$i],
                'telepon' => $phones[$i],
                'email' => $emails[$i],
                'judul_konsultasi' => $topics[$i],
                'deskripsi' => 'Saya ingin mendapatkan informasi lebih lanjut tentang ' . strtolower($topics[$i]) . '.',
                'status' => $status,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // 2. Insert ke kategori_pelatihan
            $jenis_kategori = $kategoriList[array_rand($kategoriList)];
            $id_kategori = DB::table('kategori_pelatihan')->insertGetId([
                'id_konsultasi' => $id_konsultasi,
                'jenis_kategori' => $jenis_kategori,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // 3. Insert ke jenis_pelatihan
            if ($jenis_kategori === 'inti') {
                DB::table('jenis_pelatihan')->insert([
                    'id_kategori' => $id_kategori,
                    'pelatihan_inti' => $pelatihanInti[array_rand($pelatihanInti)],
                    'tanggal_pengajuan' => $date->copy()->subDays(rand(1, 30))->format('Y-m-d'),
                    'pelatihan_pendukung' => null,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            } else {
                DB::table('jenis_pelatihan')->insert([
                    'id_kategori' => $id_kategori,
                    'pelatihan_inti' => null,
                    'tanggal_pengajuan' => $date->copy()->subDays(rand(1, 30))->format('Y-m-d'),
                    'pelatihan_pendukung' => $pelatihanPendukung[array_rand($pelatihanPendukung)],
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }

            // 4. Jika status Dijawab, insert ke jawab_konsultasi
            if ($status === 'Dijawab') {
                DB::table('jawab_konsultasi')->insert([
                    'id_konsultasi' => $id_konsultasi,
                    'jawaban' => 'Ini adalah jawaban otomatis untuk konsultasi ' . $topics[$i],
                    'tanggal_dijawab' => $date->copy()->addDays(rand(1, 5)),
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
