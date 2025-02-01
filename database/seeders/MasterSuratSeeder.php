<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_surat')->insert([
            [
                'nomor_surat' => '001/SM/2023',
                'tanggal_surat' => '2023-10-01',
                'perihal' => 'Undangan Rapat Koordinasi',
                'pengirim' => 'Badan Pengawas Daerah',
                'penerima' => 'Dinas Pendidikan',
                'status' => 'Masuk',
                'keterangan' => 'Surat masuk untuk rapat koordinasi bulanan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '002/SM/2023',
                'tanggal_surat' => '2023-10-05',
                'perihal' => 'Permohonan Data Kepegawaian',
                'pengirim' => 'Dinas Kesehatan',
                'penerima' => 'Badan Kepegawaian Daerah',
                'status' => 'Proses',
                'keterangan' => 'Surat sedang diproses oleh bagian kepegawaian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '003/SM/2023',
                'tanggal_surat' => '2023-10-10',
                'perihal' => 'Laporan Keuangan Triwulan III',
                'pengirim' => 'Dinas Pekerjaan Umum',
                'penerima' => 'Badan Pengelola Keuangan Daerah',
                'status' => 'Keluar',
                'keterangan' => 'Surat keluar berupa laporan keuangan triwulan III.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '004/SM/2023',
                'tanggal_surat' => '2023-10-15',
                'perihal' => 'Permohonan Izin Kegiatan',
                'pengirim' => 'Organisasi Pemuda',
                'penerima' => 'Dinas Pemuda dan Olahraga',
                'status' => 'Masuk',
                'keterangan' => 'Surat masuk untuk permohonan izin kegiatan pemuda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '005/SM/2023',
                'tanggal_surat' => '2023-10-20',
                'perihal' => 'Pengumuman Hasil Seleksi',
                'pengirim' => 'Badan Kepegawaian Daerah',
                'penerima' => 'Seluruh Pegawai',
                'status' => 'Proses',
                'keterangan' => 'Surat sedang diproses untuk pengumuman hasil seleksi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
