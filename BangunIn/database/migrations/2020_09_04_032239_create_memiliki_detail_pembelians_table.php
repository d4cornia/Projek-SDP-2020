<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemilikiDetailPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memiliki_detail_pembelians', function (Blueprint $table) {
            $table->integerIncrements('id_detail_pembelian');
            $table->integer('id_pembelian');
            $table->integer('id_bahan');
            $table->integer('jumlah_barang');
            $table->integer('harga_satuan');
            $table->float('persen_diskon');
            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memiliki_detail_pembelians');
    }
}
