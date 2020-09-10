<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->integerIncrements('kode_admin');
            $table->integer('kode_kontraktor')->unsigned();
            $table->foreign('kode_kontraktor')->references('kode_kontraktor')->on('kontraktors');
            $table->string('nama_admin', 50);
            $table->string('no_hp_admin', 13);
            $table->string('username_admin', 50);
            $table->string('email_admin', 50);
            $table->integer('gaji_admin');
            $table->string('password_admin', 30);
            $table->string('status_delete_admin',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
