<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bank_soal', function (Blueprint $table) {
            $table->string('id_modul')->nullable()->after('id');
            $table->string('id_tematik')->nullable()->after('id_modul');
        });
    }

    public function down(): void
    {
        Schema::table('bank_soal', function (Blueprint $table) {
            $table->dropColumn(['id_modul', 'id_tematik']);
        });
    }
};
