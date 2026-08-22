<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah kolom status menggunakan Raw Query agar mendukung opsi Tripay
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('UNPAID', 'PAID', 'EXPIRED', 'FAILED', 'PENDING') DEFAULT 'UNPAID'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('PENDING', 'PAID', 'EXPIRED', 'FAILED') DEFAULT 'PENDING'");
        });
    }
};
