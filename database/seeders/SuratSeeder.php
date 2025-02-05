<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk master_surat
        DB::table('master_surat')->insert([
            [
                'nomor_surat' => '001/SMT/2023',
                'tanggal_surat' => Carbon::create(2023, 1, 15),
                'perihal' => 'Permohonan Izin',
                'pengirim' => 'Dinas Perizinan Kalimantan',
                'status' => 'Proses',
                'keterangan' => null,
                'id_user' => 1,
                'file_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '002/SMT/2023',
                'tanggal_surat' => Carbon::create(2023, 2, 20),
                'perihal' => 'Pengajuan Bantuan',
                'pengirim' => 'Dinas Sosial Kalimantan',
                'status' => 'Terima',
                'keterangan' => 'Diterima dan diproses',
                'id_user' => 1,
                'file_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => '003/SMT/2023',
                'tanggal_surat' => Carbon::create(2023, 3, 10),
                'perihal' => 'Laporan Kegiatan',
                'pengirim' => 'Dinas Pendidikan Kalimantan',
                'status' => 'Tolak',
                'keterangan' => 'Tidak lengkap',
                'id_user' => 1,
                'file_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder untuk surat_proses
        DB::table('surat_proses')->insert([
            [
                'id_surat' => 1,
                'tanggal_proses' => Carbon::create(2023, 1, 16),
                'catatan_proses' => 'Proses awal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_surat' => 2,
                'tanggal_proses' => Carbon::create(2023, 2, 21),
                'catatan_proses' => 'Diterima dan diproses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_surat' => 3,
                'tanggal_proses' => Carbon::create(2023, 3, 11),
                'catatan_proses' => 'Diperiksa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder untuk surat_tolak
        DB::table('surat_tolak')->insert([
            [
                'id_surat' => 3,
                'id_proses' => 3,
                'tanggal_tolak' => Carbon::create(2023, 3, 12),
                'alasan_tolak' => 'Dokumen tidak lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder untuk surat_terima
        DB::table('surat_terima')->insert([
            [
                'id_surat' => 2,
                'id_proses' => 2,
                'tanggal_terima' => Carbon::create(2023, 2, 22),
                'catatan_terima' => 'Diterima dengan baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}