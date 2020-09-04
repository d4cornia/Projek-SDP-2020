<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanBangunansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_bangunans', function (Blueprint $table) {
            $table->integerIncrements('id_bahan');
            $table->integer('id_kerjasama')->unsigned();
            $table->foreign('id_kerjasama')->references('id_kerjasama')->on('toko_bangunans');
            $table->string('nama_bahan',50);
            $table->integer('harga_satuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bahan_bangunans');
    }
}
