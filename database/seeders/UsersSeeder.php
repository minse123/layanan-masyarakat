<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'telepon' => '087855068531',
                'role' => 'admin',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'telepon' => '089999999999',
                'role' => 'user',
                'password' => bcrypt('user123')
            ],
            [
                'name' => 'kasubag',
                'email' => 'kasubag@gmail.com',
                'telepon' => '089999999999',
                'role' => 'kasubag',
                'password' => bcrypt('kasubag123')
            ],

        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
