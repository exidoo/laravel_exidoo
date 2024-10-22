<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('patients')->insert([
            ['nama_pasien' => 'Budi', 'alamat' => 'Jl. Mawar', 'telepon' => '08123456789', 'hospital_id' => 1],
            ['nama_pasien' => 'Siti', 'alamat' => 'Jl. Melati', 'telepon' => '08198765432', 'hospital_id' => 2]
        ]);
    }
}
