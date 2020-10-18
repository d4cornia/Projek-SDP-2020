<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenHarians extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_harians', function (Blueprint $table) {
            $table->integerIncrements('kode_absen_harians');
            $table->integer('kode_pekerjaan')->unsigned()->nullable();
            $table->foreign('kode_pekerjaan')->references('kode_pekerjaan')->on('pekerjaans');
            $table->integer('kode_mandor')->unsigned();
            $table->foreign('kode_mandor')->references('kode_mandor')->on('mandors');
            $table->string('tanggal_absen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_harians');
    }
}
