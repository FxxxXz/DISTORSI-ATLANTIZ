<?php
// database/migrations/2024_01_15_000005_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('kode_pembayaran')->unique();
            $table->enum('metode', ['transfer', 'cash', 'ewallet']);
            $table->decimal('jumlah', 12, 2);
            $table->string('bukti_transfer')->nullable();
            $table->timestamp('dibayar_pada')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};