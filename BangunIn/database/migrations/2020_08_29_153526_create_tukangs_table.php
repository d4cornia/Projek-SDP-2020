<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTukangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tukang', function (Blueprint $table) {
            $table->string('kode_tukang',5);
            $table->string('kode_jenis',5);
            $table->string('nama_tukang',25);
            $table->primary('kode_tukang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tukang');
    }
}
