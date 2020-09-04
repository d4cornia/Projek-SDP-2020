<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePkMemakaiBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk_memakai_bahans', function (Blueprint $table) {
            $table->integerIncrements('id_pk_memakai_bahan',1);
            $table->integer('id_pembelian')->unsigned();
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelians');
            $table->integer('kode_pk')->unsigned();
            $table->foreign('kode_pk')->references('kode_pk')->on('pekerjaan_khususes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pk_memakai_bahans');
    }
}
