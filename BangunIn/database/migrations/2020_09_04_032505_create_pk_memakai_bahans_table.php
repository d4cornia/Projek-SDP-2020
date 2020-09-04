<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePkMemakaiBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk_memakai_bahans', function (Blueprint $table) {
            $table->integerIncrements('id_pk_memakai_bahan',1);
            $table->integer('id_pembelian');
            $table->integer('kode_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pk_memakai_bahans');
    }
}
