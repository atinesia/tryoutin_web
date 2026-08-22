<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Akun Admin Utama
        User::updateOrCreate(
            ['email' => 'admin@tryoutin.com'],
            [
                'name'     => 'Super Admin Tryoutin',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // 2. Akun Peserta Contoh
        User::updateOrCreate(
            ['email' => 'peserta@gmail.com'],
            [
                'name'     => 'Budi Peserta',
                'password' => Hash::make('password123'),
                'role'     => 'user',
            ]
        );
    }
}
