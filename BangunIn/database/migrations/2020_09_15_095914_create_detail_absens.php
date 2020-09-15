<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailAbsen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_absen', function (Blueprint $table) {
            $table->integerIncrements('kode_detail');
            $table->integer('kode_absen')->unsigned();
            $table->foreign('kode_absen')->references('kode_absen')->on('bukti_absens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_absen');
    }
}
