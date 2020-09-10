<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePekerjaanKhususesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pekerjaan_khususes', function (Blueprint $table) {
            $table->integerIncrements('kode_pk');
            $table->integer('kode_pekerjaan')->unsigned();
            $table->foreign('kode_pekerjaan')->references('kode_pekerjaan')->on('pekerjaans');
            $table->string('keterangan_pk', 100);
            $table->string('membutuhkan_bahan', 1);
            $table->integer('total_bahan');
            $table->integer('total_jasa');
            $table->integer('total_keseluruhan');
            $table->string('status_delete_pk', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan_khususes');
    }
}
