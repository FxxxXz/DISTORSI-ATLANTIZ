<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah admin sudah ada, jika belum buat
        if (!User::where('email', 'admin@distorsiatlantiz.com')->exists()) {
            User::create([
                'nama_lengkap' => 'User',
                'username' => 'user',
                'email' => 'user@distorsiatlantiz.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                // 'is_active' => true, // Hapus sementara
            ]);
        }

        // Buat admin kedua (opsional)
        if (!User::where('email', 'superadmin@distorsiatlantiz.com')->exists()) {
            User::create([
                'nama_lengkap' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@distorsiatlantiz.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                // 'is_active' => true, // Hapus sementara
            ]);
        }
    }
}
