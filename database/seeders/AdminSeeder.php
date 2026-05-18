<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat user biasa (opsional)
        if (!User::where('email', 'user@distorsi.com')->exists()) {
            User::create([
                'nama_lengkap' => 'User Biasa',
                'username' => 'user',
                'email' => 'user@distorsi.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'is_active' => true,
            ]);
        }

        // Buat admin sesuai request
        if (!User::where('email', 'admin@distorsi.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@distorsi.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]);
        }
    }
}