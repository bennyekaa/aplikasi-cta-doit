<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ref_modul', function (Blueprint $table) {
            $table->integer('waktu')->default(0)->after('nama_modul');
            $table->dropColumn(['passing_grade', 'keterangan']);
        });
    }

    public function down(): void
    {
        Schema::table('ref_modul', function (Blueprint $table) {
            $table->dropColumn('waktu');
            $table->integer('passing_grade')->nullable();
            $table->string('keterangan')->nullable();
        });
    }
};
