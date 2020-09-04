<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaans', function (Blueprint $table) {
            $table->integerIncrements('kode_pekerjaan');
            $table->integer('kode_kontraktor');
            $table->integer('kode_client');
            $table->integer('kode_admin');
            $table->integer('kode_mandor');
            $table->string('nama_pekerjaan',50);
            $table->string('alamat_pekerjaan',50);
            $table->string('perjanjian_khusus',100);
            $table->string('jenis_pekerjaan',1);
            $table->integer('harga_deal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaans');
    }
}
