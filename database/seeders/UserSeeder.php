<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin123', // Menggunakan username
            'password' => Hash::make('password123'), // Hash password untuk keamanan
        ]);

        User::create([
            'name' => 'User1',
            'username' => 'user123', // Username kedua
            'password' => Hash::make('password456'), // Hash password untuk keamanan
        ]);
    }
}
