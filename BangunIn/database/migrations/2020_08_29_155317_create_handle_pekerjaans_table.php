<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandlePekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handle_pekerjaan', function (Blueprint $table) {
            $table->string('kode_pekerjaan',5);
            $table->string('kode_kontraktor',5);
            $table->string('status_jadi',1);
            $table->string('penawaran',200);
            $table->integer('hargadeal',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('handle_pekerjaan');
    }
}
