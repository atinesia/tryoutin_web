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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'reference')) {
                $table->string('reference')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('orders', 'merchant_ref')) {
                $table->string('merchant_ref')->nullable()->unique()->after('reference');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('exam_id');
            }
            if (!Schema::hasColumn('orders', 'payment_name')) {
                $table->string('payment_name')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'pay_code')) {
                $table->string('pay_code')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('orders', 'qr_url')) {
                $table->text('qr_url')->nullable()->after('pay_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['reference', 'merchant_ref', 'payment_method', 'payment_name', 'pay_code', 'qr_url']);
        });
    }
};
