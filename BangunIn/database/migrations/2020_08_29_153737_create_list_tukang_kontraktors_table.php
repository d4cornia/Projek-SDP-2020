<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListTukangKontraktorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_tukang_kontraktor', function (Blueprint $table) {
            $table->string('kode_kontraktor',5);
            $table->string('kode_tukang',5);
            $table->integer('gaji_pokok_tukang',6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_tukang_kontraktor');
    }
}
