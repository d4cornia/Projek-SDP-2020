<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokoBangunansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toko_bangunans', function (Blueprint $table) {
            $table->integerIncrements('id_kerjasama');
            $table->integer('kode_toko');
            $table->string('nama_toko',50);
            $table->string('alamat_toko',50);
            $table->string('no_hp_toko',13);
            $table->integer('kode_kontraktor')->unsigned();
            $table->foreign('kode_kontraktor')->references('kode_kontraktor')->on('kontraktors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toko_bangunans');
    }
}
