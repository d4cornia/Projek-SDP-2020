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
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->string('kode_pekerjaan',5);
            $table->string('kode_client',5);
            $table->string('nama_pekerjaan',5);
            $table->string('alamat_pekerjaan',50);
            $table->string('perjanjian_khusus',100);
            $table->string('jenis_pekerjaan',1);
            $table->primary('kode_pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pekerjaan');
    }
}
