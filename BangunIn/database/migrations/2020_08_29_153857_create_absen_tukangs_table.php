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
        Schema::create('absen_tukang', function (Blueprint $table) {
            $table->string('kode_kontraktor',5);
            $table->string('kode_tukang',5);
            $table->date('tanggal');
            $table->integer('ongkos_lembur',6);
            $table->date('tanggal_bayar');
            $table->string('status_setuju_absen',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_tukang');
    }
}
