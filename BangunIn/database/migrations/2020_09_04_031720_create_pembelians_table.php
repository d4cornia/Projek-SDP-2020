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
            $table->integer('id_bukti');
            $table->integer('id_kerjasama');
            $table->integer('kode_pekerjaan');
            $table->integer('total_pembelian');
            $table->date('tanggal_beli');
            $table->date('tanggal_bayar');
            $table->date('tanggal_jatuh_tempo');
            $table->string('status_lunas_bon_toko',1);
            $table->string('status_pembayaran_oleh',1);
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
