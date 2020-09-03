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
            $table->string('kode_kontraktor',5);
            $table->string('nama_mandor',50);
            $table->string('no_hp_mandor',13);
            $table->string('username_mandor',50);
            $table->string('email_mandor',50);
            $table->string('password_mandor',30);
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
