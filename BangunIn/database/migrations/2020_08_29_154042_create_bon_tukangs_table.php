<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_tukang', function (Blueprint $table) {
            $table->string('kode_bon',5);
            $table->string('kode_kontraktor',5);
            $table->string('kode_tukang',5);
            $table->date('tanggal_pengajuan');
            $table->integer('jumlah_bon',7);
            $table->string('status_lunas_bon',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bon_tukang');
    }
}
