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
        Schema::create('ref_desa', function (Blueprint $table) {
            $table->uuid('id_desa')->primary();
            $table->uuid('id_kecamatan')->nullable();
            $table->string('kode_desa')->nullable();
            $table->string('nama_desa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_desa');
    }
};
