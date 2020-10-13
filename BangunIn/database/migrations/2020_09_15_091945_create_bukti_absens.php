<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktiAbsens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukti_absens', function (Blueprint $table) {
            $table->integerIncrements('kode_absen');
            $table->integer('kode_tukang')->unsigned();
            $table->foreign('kode_tukang')->references('kode_tukang')->on('tukangs');
            $table->string('tanggal_absen');
            $table->string('bukti_foto_absen', 100);
            $table->string('konfirmasi_absen', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukti_absens');
    }
}
