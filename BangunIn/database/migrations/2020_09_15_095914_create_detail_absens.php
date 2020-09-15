<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAbsens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_absens', function (Blueprint $table) {
            $table->integerIncrements('kode_detail');
            $table->integer('kode_absen_harians')->unsigned();
            $table->integer('ongkos_lembur')->unsigned();
            $table->foreign('kode_absen_harians')->references('kode_absen_harians')->on('absen_harians');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_absens');
    }
}
