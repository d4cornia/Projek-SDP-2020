<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPermintaanUangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_permintaan_uangs', function (Blueprint $table) {
            $table->integerIncrements('id_detail_permintaan_uang');
            $table->integer('id_permintaan_uang');
            $table->integer('kode_pekerjaan');
            $table->integer('claim_nota_pembelian');
            $table->integer('total_gaji_tukang');
            $table->integer('total_bon_tukang');
            $table->integer('total_gaji_mandor');
            $table->integer('real_total');
            $table->string('keterangan',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_permintaan_uangs');
    }
}
