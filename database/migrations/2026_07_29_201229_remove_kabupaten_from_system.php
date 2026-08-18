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
        Schema::table('ref_kecamatan', function (Blueprint $table) {
            $table->dropColumn('id_kabupaten');
        });
        Schema::dropIfExists('ref_kabupaten');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('ref_kabupaten', function (Blueprint $table) {
            $table->uuid('id_kabupaten')->primary();
            $table->string('kode_kabupaten')->nullable();
            $table->string('nama_kabupaten')->nullable();
            $table->timestamps();
        });
        Schema::table('ref_kecamatan', function (Blueprint $table) {
            $table->uuid('id_kabupaten')->nullable();
        });
    }
};
