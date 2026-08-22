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
        // 1. Tambah Kolom Profil Siswa & Role Afiliator/Tutor
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'school_origin')) {
                $table->string('school_origin')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'referral_code')) {
                $table->string('referral_code')->nullable()->unique()->after('school_origin');
            }
            if (!Schema::hasColumn('users', 'referred_by')) {
                $table->string('referred_by')->nullable()->after('referral_code');
            }
            // Ubah Enum Role pendukung
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user', 'tutor', 'affiliate') DEFAULT 'user'");
        });

        // 2. Tabel Tiket Lapor Kendala
        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('subject');
                $table->text('message');
                $table->enum('status', ['OPEN', 'IN_PROGRESS', 'RESOLVED'])->default('OPEN');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
