<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Studio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nama_lengkap' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@distorsiatlantiz.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Studios
        Studio::create([
            'nama' => 'Studio Regular',
            'slug' => 'studio-regular',
            'tipe' => 'regular',
            'deskripsi' => 'Ruang latihan standar dengan peralatan lengkap untuk band 4-5 orang.',
            'fasilitas' => ['Drum Kit Standar', 'Ampli Gitar & Bass', 'Sound System 500W', 'AC & WiFi', 'Ruang 20m²'],
            'harga_per_jam' => 75000,
            'kapasitas' => 5,
            'foto' => 'img/studio-regular.png',
            'is_populer' => true,
        ]);

        Studio::create([
            'nama' => 'Studio Premium',
            'slug' => 'studio-premium',
            'tipe' => 'premium',
            'deskripsi' => 'Ruang dengan peralatan premium dan akustik profesional untuk hasil maksimal.',
            'fasilitas' => ['Drum Kit Premium', 'Ampli Tube High-End', 'Sound System 1000W', 'Recording Ready', 'Ruang 30m²'],
            'harga_per_jam' => 150000,
            'kapasitas' => 8,
            'foto' => 'img/studio-premium.png',
            'is_best_value' => true,
        ]);

        Studio::create([
            'nama' => 'Recording Studio',
            'slug' => 'recording-studio',
            'tipe' => 'recording',
            'deskripsi' => 'Ruang rekaman profesional dengan engineer berpengalaman.',
            'fasilitas' => ['Multi-track Recording', 'Pro Tools & Logic Pro', 'Sound Engineer', 'Mixing & Mastering', 'Ruang 40m²'],
            'harga_per_jam' => 125000,
            'harga_per_sesi' => 500000,
            'durasi_sesi' => 4,
            'kapasitas' => 10,
            'foto' => 'img/studio-recording.png',
        ]);
    }
}