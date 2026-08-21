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
        Schema::create('user_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();

            // Skor Akhir
            $table->integer('score_twk')->default(0);
            $table->integer('score_tiu')->default(0);
            $table->integer('score_tkp')->default(0);
            $table->integer('total_score')->default(0);
            $table->boolean('is_passed')->default(false);

            $table->enum('status', ['ON_PROGRESS', 'FINISHED', 'EXPIRED'])->default('ON_PROGRESS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exams');
    }
};
