<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KonsultasiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Daftar nama khas Kalimantan
        $nama_kalimantan = [
            'Budi',
            'Siti',
            'Jamilah',
            'Herman',
            'Alamsyah',
            'Wahyuni',
            'Taufik',
            'Nurul',
            'Marlina',
            'Asep',
            'Yusuf',
            'Kirana',
            'Teguh',
            'Khadijah',
            'Rizki',
            'Anwar',
            'Reni',
            'Hasanah',
            'Siti Zulaikha',
            'Maya',
            'Gustav',
            'Indri',
            'Andi',
            'Mira'
        ];

        // Seed untuk tabel master_konsultasi
        for ($i = 0; $i < 10; $i++) {
            $id_konsultasi = DB::table('master_konsultasi')->insertGetId([
                'nama' => $nama_kalimantan[array_rand($nama_kalimantan)],  // Pilih nama acak dari array
                'telepon' => $faker->phoneNumber,
                'email' => $faker->email,
                'judul_konsultasi' => $faker->sentence,
                'deskripsi' => $faker->paragraph,
                'status' => 'Pending', // Default status
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Seed untuk tabel konsultasi_pending
            DB::table('konsultasi_pending')->insert([
                'id_konsultasi' => $id_konsultasi,
                'tanggal_pengajuan' => $faker->date(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Seed untuk tabel konsultasi_dijawab (untuk beberapa konsultasi)
            if (rand(0, 1)) {  // Beberapa konsultasi akan dijawab
                DB::table('konsultasi_dijawab')->insert([
                    'id_konsultasi' => $id_konsultasi,
                    'jawaban' => $faker->paragraph,
                    'tanggal_dijawab' => $faker->date(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
