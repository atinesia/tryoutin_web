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
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'sub_category')) {
                $table->string('sub_category')->nullable()->after('category');
            }
            if (!Schema::hasColumn('questions', 'difficulty')) {
                $table->enum('difficulty', ['Mudah', 'Sedang', 'HOTS'])->default('Sedang')->after('sub_category');
            }
            if (!Schema::hasColumn('questions', 'score_right')) {
                $table->integer('score_right')->default(5)->after('discussion_text');
            }
            if (!Schema::hasColumn('questions', 'score_wrong')) {
                $table->integer('score_wrong')->default(0)->after('score_right');
            }
            if (!Schema::hasColumn('questions', 'score_unanswered')) {
                $table->integer('score_unanswered')->default(0)->after('score_wrong');
            }

            // Kolom Skor Opsi A-E (Khusus TKP / Bobot Gradasi)
            if (!Schema::hasColumn('questions', 'score_a')) {
                $table->integer('score_a')->default(0)->after('score_unanswered');
                $table->integer('score_b')->default(0)->after('score_a');
                $table->integer('score_c')->default(0)->after('score_b');
                $table->integer('score_d')->default(0)->after('score_c');
                $table->integer('score_e')->default(0)->after('score_d');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn([
                'sub_category',
                'difficulty',
                'score_right',
                'score_wrong',
                'score_unanswered',
                'score_a',
                'score_b',
                'score_c',
                'score_d',
                'score_e'
            ]);
        });
    }
};
