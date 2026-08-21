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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['TWK', 'TIU', 'TKP']);
            $table->text('question_text');
            $table->string('question_image')->nullable();

            // Opsi Jawaban
            $table->text('option_a');
            $table->text('option_b');
            $table->text('option_c');
            $table->text('option_d');
            $table->text('option_e');

            // Skor Pilihan (Untuk TKP nilai opsi A-E bisa 1 s/d 5. Untuk TWK/TIU kunci jawaban diisi 5, sisanya 0)
            $table->integer('score_a')->default(0);
            $table->integer('score_b')->default(0);
            $table->integer('score_c')->default(0);
            $table->integer('score_d')->default(0);
            $table->integer('score_e')->default(0);

            $table->text('discussion_text')->nullable(); // Pembahasan Soal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
