<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranBonTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_bon_tukangs', function (Blueprint $table) {
            $table->integerIncrements('id_detail_bon');
            $table->integer('kode_tukang');
            $table->integer('kode_pembayaran_bon');
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
        Schema::dropIfExists('pembayaran_bon_tukangs');
    }
}
