<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->integerIncrements('id_pembelian');
            $table->integer('id_bukti')->unsigned();
            $table->foreign('id_bukti')->references('id_bukti')->on('bukti_pembelian_mandors');
            $table->integer('id_kerjasama')->unsigned();
            $table->foreign('id_kerjasama')->references('id_kerjasama')->on('toko_bangunans');
            $table->integer('kode_pekerjaan')->unsigned();
            $table->foreign('kode_pekerjaan')->references('kode_pekerjaan')->on('pekerjaans');
            $table->integer('total_pembelian');
            $table->date('tanggal_beli')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->string('status_lunas_bon_toko', 1)->nullable();
            $table->string('status_pembayaran_oleh', 1);
            $table->string('status_request_dana', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
}
