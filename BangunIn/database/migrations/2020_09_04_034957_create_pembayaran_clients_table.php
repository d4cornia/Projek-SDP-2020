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
            $table->integer('kode_pekerjaan');
            $table->integer('kode_client');
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
