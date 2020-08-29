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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id_pembelian',5);
            $table->string('kode_toko',5);
            $table->string('kode_pekerjaan',5);
            $table->integer('total',10);
            $table->date('tanggal_beli');
            $table->date('tanggal_bayar');
            $table->date('tanggal_jatuh_tempo');
            $table->string('status_lunas_pembelian',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}
