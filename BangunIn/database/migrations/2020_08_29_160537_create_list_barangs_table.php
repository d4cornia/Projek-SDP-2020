<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_barang', function (Blueprint $table) {
            $table->string('kode_toko',5);
            $table->string('kode_bahan',5);
            $table->string('id_list_barang',5);
            $table->integer('harga_satuan',7);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_barang');
    }
}
