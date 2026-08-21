<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // ID Referensi dari Tripay (DEV-Txxxx)
            $table->string('merchant_ref')->unique(); // TRYO-20260816-xxx
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->string('payment_method');
            $table->string('payment_name')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('pay_code')->nullable(); // Kode VA / Kode Alfamart / URL QRIS
            $table->text('qr_url')->nullable();
            $table->enum('status', ['UNPAID', 'PAID', 'EXPIRED', 'FAILED'])->default('UNPAID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
