<?php
// database/migrations/xxxx_add_qris_to_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Ganti enum lama dengan yang baru (kalau belum ada qris)
            // Atau kalau baru bikin, langsung pakai yang ini di migration awal
        });
    }

    public function down(): void
    {
        //
    }
};