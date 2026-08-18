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
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('instansi');
            $table->dropColumn(['nomor', 'alamat', 'owner']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->string('nomor')->nullable();
            $table->string('alamat')->nullable();
            $table->string('owner')->nullable();
        });
    }
};
