<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengaturan;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::create([
            'nama_laundry' => 'Laundry Bos',
            'alamat'       => 'Smks Nurul Islam',
            'no_hp'        => '081234567890',
            'logo'         => null,
        ]);
    }
}

