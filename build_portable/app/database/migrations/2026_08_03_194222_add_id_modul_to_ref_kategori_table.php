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
        Schema::table('ref_kategori', function (Blueprint $table) {
            $table->string('id_modul')->nullable()->after('id_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_kategori', function (Blueprint $table) {
            $table->dropColumn('id_modul');
        });
    }
};
