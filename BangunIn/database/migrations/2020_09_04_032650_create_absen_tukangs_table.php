<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen_tukangs', function (Blueprint $table) {
            $table->integerIncrements('kode_absen');
            $table->integer('kode_tukang');
            $table->integer('kode_pekerjaan');
            $table->date('tanggal_absen');
            $table->integer('ongkos_lembur');
            $table->string('bukti_kerja',100);
            $table->string('status_persetujuan',1);
            $table->string('konfirmasi_pembayaran',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_tukangs');
    }
}
