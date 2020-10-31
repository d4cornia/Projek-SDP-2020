<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanUangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_uangs', function (Blueprint $table) {
            $table->integerIncrements('id_permintaan_uang');
            $table->integer('kode_mandor')->unsigned();
            $table->foreign('kode_mandor')->references('kode_mandor')->on('mandors');
            $table->date('tanggal_permintaan_uang');
            $table->string('konfirmasi_kontraktor_telah_transfer',1);
            $table->string('bukti_trf_req',100);
            $table->integer('total_permintaan_uang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_uangs');
    }
}
