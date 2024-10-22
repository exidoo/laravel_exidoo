<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('hospitals')->insert([
            ['nama_rumah_sakit' => 'RS Umum', 'alamat' => 'Jl. Sehat', 'email' => 'rsumum@mail.com', 'telepon' => '021123456'],
            ['nama_rumah_sakit' => 'RS Khusus', 'alamat' => 'Jl. Spesialis', 'email' => 'rskhusus@mail.com', 'telepon' => '021654321']
        ]);
    }

}
