<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Hash; // Import Hash

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234567890',
            'alamat' => 'Kantor Pusat',
            'role' => 'admin', // Set peran sebagai admin
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
        ]);
    }
}
