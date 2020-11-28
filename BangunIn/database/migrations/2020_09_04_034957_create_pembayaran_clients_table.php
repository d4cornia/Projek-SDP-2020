<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_clients', function (Blueprint $table) {
            $table->integerIncrements('kode_pembayaran_client');
            $table->integer('id_tagihan')->unsigned()->nullable()->default(0);
            $table->integer('kode_pekerjaan')->unsigned();
            $table->foreign('kode_pekerjaan')->references('kode_pekerjaan')->on('pekerjaans');
            $table->integer('kode_client')->unsigned();
            $table->foreign('kode_client')->references('kode_client')->on('clients');
            $table->date('tanggal_pembayan_client');
            $table->integer('jumlah_pembayaran_client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_clients');
    }
}
