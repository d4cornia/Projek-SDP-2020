<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PkDanas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk_danas', function (Blueprint $table) {
            $table->integerIncrements('kode_pk_dana');
            $table->integer('kode_pk')->unsigned();
            $table->foreign('kode_pk')->references('kode_pk')->on('pekerjaan_khususes');
            $table->string('bukti_tsf_dana', 100);
            $table->integer('dana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pk_danas');
    }
}
