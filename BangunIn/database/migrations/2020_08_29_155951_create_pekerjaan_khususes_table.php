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
        Schema::create('pekerjaan_khusus', function (Blueprint $table) {
            $table->string('kode_pk',5);
            $table->string('kode_pekerjaan',5);
            $table->string('keterangan_pk',50);
            $table->integer('harga',9);
            $table->date('tanggal_pembayaran');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan_khusus');
    }
}
