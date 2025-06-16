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
            // [
            //     'name' => 'operator',
            //     'email' => 'operator@gmail.com',
            //     'telepon' => '087777777777',
            //     'role' => 'operator',
            //     'password' => bcrypt('operator123')
            // ],
            // [
            //     'name' => 'psm',
            //     'email' => 'psm@gmail.com',
            //     'telepon' => '089999999999',
            //     'role' => 'psm',
            //     'password' => bcrypt('psm123')
            // ],
            // [
            //     'name' => 'masyarakat',
            //     'email' => 'masyarakat@gmail.com',
            //     'telepon' => '089999999999',
            //     'role' => 'masyarakat',
            //     'password' => bcrypt('masyarakat123')
            // ],

        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
