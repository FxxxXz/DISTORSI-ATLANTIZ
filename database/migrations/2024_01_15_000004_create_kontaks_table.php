<?php
// database/migrations/2024_01_15_000004_create_kontaks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->enum('subjek', ['umum', 'booking', 'recording', 'event', 'lainnya']);
            $table->text('pesan');
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
            $table->timestamp('dibaca_pada')->nullable();
            $table->foreignId('dibaca_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontaks');
    }
};