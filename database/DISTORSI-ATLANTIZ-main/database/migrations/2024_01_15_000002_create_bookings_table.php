<?php
// database/migrations/2024_01_15_000002_create_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('studio_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->unsignedTinyInteger('durasi');
            $table->unsignedBigInteger('total_harga');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->text('alasan_pembatalan')->nullable();  // TAMBAHAN
            $table->timestamp('dibatalkan_pada')->nullable(); // TAMBAHAN
            $table->timestamps();
            
            $table->index(['studio_id', 'tanggal', 'status']); // Index untuk performa cek jadwal
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};