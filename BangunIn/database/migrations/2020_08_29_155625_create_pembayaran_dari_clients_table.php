<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranDariClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_dari_client', function (Blueprint $table) {
            $table->string('kode_pembayaran_client',5);
            $table->string('kode_pekerjaan',5);
            $table->date('tanggal_pembayaran_client');
            $table->integer('jumlah_pembayaran_client',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_dari_client');
    }
}
