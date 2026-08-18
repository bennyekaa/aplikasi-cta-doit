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
        Schema::create('ref_kabupaten', function (Blueprint $table) {
            $table->uuid('id_kabupaten')->primary();
            $table->string('kode_kabupaten')->nullable();
            $table->string('nama_kabupaten')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kabupaten');
    }
};
