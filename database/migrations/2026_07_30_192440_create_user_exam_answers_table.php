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
        Schema::create('user_exam_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_exam_id');
            $table->string('id_soal', 36);
            $table->integer('nomor_soal');
            $table->json('pilihan_acak')->nullable();
            $table->string('jawaban_user')->nullable();
            $table->decimal('poin', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam_answers');
    }
};
