<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontraktorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontraktors', function (Blueprint $table) {
            $table->integerIncrements('kode_kontraktor');
            $table->string('nama_kontraktor',50);
            $table->string('no_hp_kontraktor',13);
            $table->string('username_kontraktor',50);
            $table->string('email_kontraktor',50);
            $table->string('password_kontraktor',30);
            $table->string('nama_perusahaan',30);
            $table->string('logo_perusahaan',30);
            $table->string('nomer_perusahaan',15);
            $table->string('alamat_perusahaan',30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kontraktors');
    }
}
