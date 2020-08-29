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
        Schema::create('client', function (Blueprint $table) {
            $table->string('kode_client',5);
            $table->string('nama_client',50);
            $table->string('no_hp_client',13);
            $table->string('kota_domisili_client',30);
            $table->string('no_rek_client',16);
            $table->string('atm',30);
            $table->primary('kode_client');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client');
    }
}
