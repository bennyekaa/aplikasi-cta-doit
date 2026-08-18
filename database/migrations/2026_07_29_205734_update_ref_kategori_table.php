<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ref_kategori', function (Blueprint $table) {
            $table->renameColumn('nama_kategori', 'nama_tematik');
            $table->integer('persentase')->default(0)->after('nama_kategori');
            $table->dropColumn(['menit', 'nilai_total', 'keterangan']);
        });
    }

    public function down(): void
    {
        Schema::table('ref_kategori', function (Blueprint $table) {
            $table->renameColumn('nama_tematik', 'nama_kategori');
            $table->dropColumn('persentase');
            $table->integer('menit')->nullable();
            $table->integer('nilai_total')->nullable();
            $table->string('keterangan')->nullable();
        });
    }
};
