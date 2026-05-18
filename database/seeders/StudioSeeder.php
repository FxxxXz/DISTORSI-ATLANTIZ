<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        Studio::create([
            'nama' => 'Studio Regular',
            'harga_per_jam' => 75000,
            'deskripsi' => 'Ruang latihan standar dengan peralatan lengkap untuk band 4-5 orang.',
            'fasilitas' => 'Drum Kit Standar, Ampli Gitar & Bass, Sound System 500W, AC & WiFi, Ruang 20m²',
        ]);

        Studio::create([
            'nama' => 'Studio Premium',
            'harga_per_jam' => 150000,
            'deskripsi' => 'Ruang dengan peralatan premium dan akustik profesional untuk hasil maksimal.',
            'fasilitas' => 'Drum Kit Premium, Ampli Tube High-End, Sound System 1000W, Recording Ready, Ruang 30m²',
        ]);

        Studio::create([
            'nama' => 'Recording Studio',
            'harga_per_jam' => 500000,
            'deskripsi' => 'Ruang rekaman profesional dengan engineer berpengalaman. Harga per sesi 4 jam.',
            'fasilitas' => 'Multi-track Recording, Pro Tools & Logic Pro, Sound Engineer, Mixing & Mastering, Ruang 40m²',
        ]);
    }
}