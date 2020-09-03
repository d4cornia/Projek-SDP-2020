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
            $table->string('kode_kontraktor',5);
            $table->string('nama_admin',50);
            $table->string('no_hp_admin',13);
            $table->string('username_admin',50);
            $table->string('email_admin',50);
            $table->string('password_admin',30);
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
