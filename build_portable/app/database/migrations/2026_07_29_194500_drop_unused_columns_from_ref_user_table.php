<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_user', function (Blueprint $table) {
            $table->dropColumn(['email', 'telepon', 'jk', 'alamat', 'tanggal_aktif']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_user', function (Blueprint $table) {
            $table->string('email', 255)->nullable();
            $table->char('telepon', 20)->nullable();
            $table->char('jk', 2)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_aktif')->nullable();
        });
    }
};
