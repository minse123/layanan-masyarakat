<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\JadwalPelatihan;
use Faker\Factory as Faker;

class JadwalPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $lokasi_kalimantan = [
            'Pontianak, Kalimantan Barat',
            'Singkawang, Kalimantan Barat',
            'Palangkaraya, Kalimantan Tengah',
            'Banjarmasin, Kalimantan Selatan',
            'Banjarbaru, Kalimantan Selatan',
            'Samarinda, Kalimantan Timur',
            'Balikpapan, Kalimantan Timur',
            'Tanjung Selor, Kalimantan Utara',
        ];

        $pelatihan_inti_map = [
            'bumdes' => 'Pelatihan Badan Usaha Milik Desa (BUMDES) se-Kalimantan',
            'kpmd' => 'Training Kader Pemberdayaan Masyarakat Desa (KPMD) Regional Kalimantan',
            'masyarakat_hukum_adat' => 'Workshop Penguatan Masyarakat Hukum Adat di Kalimantan',
            'pembangunan_desa_wisata' => 'Pelatihan Pengembangan Desa Wisata Berbasis Potensi Lokal Kalimantan',
            'catrans' => 'Bimbingan Teknis untuk Calon Transmigran (Catrans) di Kalimantan',
            'pelatihan_perencanaan_pembangunan_partisipatif' => 'Pelatihan Perencanaan Pembangunan Desa Partisipatif (P3DP) Kalimantan',
        ];

        $pelatihan_pendukung_map = [
            'prukades' => 'Sosialisasi Program Produk Unggulan Kawasan Perdesaan (Prukades) Kalimantan',
            'prudes' => 'Workshop Program Produk Unggulan Desa (Prudes) Kalimantan',
            'ecomerce' => 'Pelatihan E-commerce untuk UMKM Desa di Kalimantan',
        ];

        for ($i = 0; $i < 20; $i++) {
            $tanggal_mulai = $faker->dateTimeBetween('+1 week', '+1 month');
            $tanggal_selesai = $faker->dateTimeBetween($tanggal_mulai, (clone $tanggal_mulai)->modify('+5 days'));

            $is_inti = $faker->boolean;
            $pelatihan_inti = null;
            $pelatihan_pendukung = null;
            $nama_pelatihan = '';

            if ($is_inti) {
                $pelatihan_inti_key = $faker->randomElement(array_keys($pelatihan_inti_map));
                $pelatihan_inti = $pelatihan_inti_key;
                $nama_pelatihan = $pelatihan_inti_map[$pelatihan_inti_key];
            } else {
                $pelatihan_pendukung_key = $faker->randomElement(array_keys($pelatihan_pendukung_map));
                $pelatihan_pendukung = $pelatihan_pendukung_key;
                $nama_pelatihan = $pelatihan_pendukung_map[$pelatihan_pendukung_key];
            }

            JadwalPelatihan::create([
                'nama_pelatihan' => $nama_pelatihan,
                'tanggal_mulai' => $tanggal_mulai->format('Y-m-d'),
                'tanggal_selesai' => $tanggal_selesai->format('Y-m-d'),
                'jam_mulai' => $faker->time('H:i'),
                'jam_selesai' => $faker->time('H:i'),
                'lokasi' => $faker->randomElement($lokasi_kalimantan),
                'deskripsi' => $faker->paragraph,
                'pelatihan_inti' => $pelatihan_inti,
                'pelatihan_pendukung' => $pelatihan_pendukung,
            ]);
        }
    }
}
