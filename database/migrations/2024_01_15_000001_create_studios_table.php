<?php
// database/migrations/2024_01_15_000001_create_studios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->enum('tipe', ['regular', 'premium', 'recording']);
            $table->text('deskripsi');
            $table->json('fasilitas'); // array fasilitas
            $table->decimal('harga_per_jam', 12, 2);
            $table->decimal('harga_per_sesi', 12, 2)->nullable(); // untuk recording
            $table->integer('durasi_sesi')->nullable(); // jam per sesi
            $table->integer('kapasitas')->default(5);
            $table->string('foto')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->boolean('is_populer')->default(false);
            $table->boolean('is_best_value')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};