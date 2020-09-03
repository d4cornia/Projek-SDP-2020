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
        Schema::create('bon_tukangs', function (Blueprint $table) {
            $table->integerIncrements('kode_bon');
            $table->integer('kode_tukang');
            $table->date('tanggal_pengajuan');
            $table->integer('jumlah_bon');
            $table->string("status_lunas",1);
            $table->string("keterangan_bon",50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bon_tukangs');
    }
}
