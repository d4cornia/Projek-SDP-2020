<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tukangs', function (Blueprint $table) {
            $table->integerIncrements('kode_tukang');
            $table->integer('kode_jenis')->unsigned();
            $table->foreign('kode_jenis')->references('kode_jenis')->on('jenis_tukangs');
            $table->integer('kode_mandor')->unsigned();
            $table->foreign('kode_mandor')->references('kode_mandor')->on('mandors');
            $table->string('nama_tukang', 50);
            $table->string('username_tukang', 50);
            $table->string('no_hp_tukang', 13);
            $table->string('email_tukang', 50);
            $table->integer('gaji_pokok_tukang');
            $table->string('password_tukang', 30);
            $table->string('status_delete_tukang', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tukangs');
    }
}
