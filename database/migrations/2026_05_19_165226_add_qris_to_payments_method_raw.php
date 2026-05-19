<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom masih enum, kalau iya alter ke string
        $columnType = DB::selectOne("SHOW COLUMNS FROM payments WHERE Field = 'method'");
        
        if ($columnType && str_contains($columnType->Type, 'enum')) {
            DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('transfer_bank', 'e_wallet', 'virtual_account', 'qris') DEFAULT 'transfer_bank'");
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('transfer_bank', 'e_wallet', 'virtual_account') DEFAULT 'transfer_bank'");
    }
};