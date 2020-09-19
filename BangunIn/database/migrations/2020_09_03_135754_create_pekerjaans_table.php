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
            $table->integer('kode_kontraktor')->unsigned();
            $table->foreign('kode_kontraktor')->references('kode_kontraktor')->on('kontraktors');
            $table->integer('kode_client')->unsigned();
            $table->foreign('kode_client')->references('kode_client')->on('clients');
            $table->integer('kode_admin')->unsigned();
            $table->foreign('kode_admin')->references('kode_admin')->on('administrators');
            $table->integer('kode_mandor')->unsigned();
            $table->foreign('kode_mandor')->references('kode_mandor')->on('mandors');
            $table->string('nama_pekerjaan', 50);
            $table->string('alamat_pekerjaan', 50);
            $table->string('perjanjian_khusus', 100);
            $table->string('jenis_pekerjaan', 1);
            $table->integer('harga_deal');
            $table->string('status_selesai', 1);
            $table->string('status_delete_pekerjaan', 1);
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
