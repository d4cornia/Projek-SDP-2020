<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMandorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandors', function (Blueprint $table) {
            $table->integerIncrements('kode_mandor');
            $table->integer('kode_kontraktor')->unsigned();
            $table->foreign('kode_kontraktor')->references('kode_kontraktor')->on('kontraktors');
            $table->string('nama_mandor', 50);
            $table->string('no_hp_mandor', 13);
            $table->string('username_mandor', 50);
            $table->string('email_mandor', 50);
            $table->integer('gaji_mandor');
            $table->string('password_mandor', 30);
            $table->string('status_delete_mandor',1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mandors');
    }
}
