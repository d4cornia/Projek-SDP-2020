<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->integerIncrements('kode_client');
            $table->integer('kode_kontraktor')->unsigned();
            $table->foreign('kode_kontraktor')->references('kode_kontraktor')->on('kontraktors');
            $table->string('nama_client', 50);
            $table->string('no_hp_client', 13);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
