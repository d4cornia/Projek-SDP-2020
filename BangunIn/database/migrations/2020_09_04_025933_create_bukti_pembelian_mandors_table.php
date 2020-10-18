<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuktiPembelianMandorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukti_pembelian_mandors', function (Blueprint $table) {
            $table->integerIncrements('id_bukti');
            $table->integer('kode_mandor')->unsigned();
            $table->foreign('kode_mandor')->references('kode_mandor')->on('mandors');
            $table->integer('kode_pekerjaan')->unsigned();
            $table->foreign('kode_pekerjaan')->references('kode_pekerjaan')->on('pekerjaans');
            $table->string('file_bukti', 100);
            $table->string('status_input', 1);
            $table->string("status_delete_bukti", 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukti_pembelian_mandors');
    }
}
