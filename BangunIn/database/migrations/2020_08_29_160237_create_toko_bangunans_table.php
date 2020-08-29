<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokoBangunansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toko_bangunan', function (Blueprint $table) {
            $table->string('kode_toko',5);
            $table->string('nama_toko',50);
            $table->string('alamat_toko',50);
            $table->string('no_rek_toko',16);
            $table->string('atm',30);
            $table->primary('kode_toko');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toko_bangunan');
    }
}
