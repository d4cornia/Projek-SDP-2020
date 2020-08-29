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
        Schema::create('kontraktor', function (Blueprint $table) {
            $table->string('kode_kontraktor', 5);
            $table->string('nama_kontraktor', 50);
            $table->string('no_hp_kontraktor', 13);
            $table->string('kota_domisili', 30);
            $table->string('no_rek_kontraktor', 16);
            $table->string('atm', 30);
            $table->primary('kode_kontraktor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kontraktor');
    }
}
