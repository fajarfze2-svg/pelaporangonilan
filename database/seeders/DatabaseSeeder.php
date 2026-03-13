<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',           // Pakai Username
            'password' => Hash::make('password'), // Wajib Hash::make()
            'role' => 'admin',
        ]);

        // 2. Teknisi
        User::create([
            'name' => 'Teknisi Satu',
            'username' => 'teknisi1',        // Pakai Username
            'password' => Hash::make('password'),
            'role' => 'teknisi',
        ]);
    }
}
