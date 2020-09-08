<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemilikiDetailBonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memiliki_detail_bons', function (Blueprint $table) {
            $table->integerIncrements('id_detail_bon');
            $table->integer('kode_bon')->unsigned();
            $table->foreign('kode_bon')->references('kode_bon')->on('bon_tukangs');
            $table->integer('kode_pembayaran_bon')->unsigned();
            $table->foreign('kode_pembayaran_bon')->references('kode_pembayaran_bon')->on('pembayaran_bon_tukangs');
            $table->integer('jumlah_pembayaran_bon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memiliki_detail_bons');
    }
}
