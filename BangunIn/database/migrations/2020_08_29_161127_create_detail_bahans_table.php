<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bahan', function (Blueprint $table) {
            $table->string('id_pembelian',5);
            $table->string('id_list_barang',5);
            $table->string('id_detail_bahan',5);
            $table->string('status_pk',1);
            $table->string('jumlahbarang',3);
            $table->float('persendiskon');
            $table->string('harga_satuan',7);
            $table->string('subtotal',7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_bahan');
    }
}
