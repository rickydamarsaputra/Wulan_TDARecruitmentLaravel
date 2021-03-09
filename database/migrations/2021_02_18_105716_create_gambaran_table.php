<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGambaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gambaran', function (Blueprint $table) {
            $table->id('ID_gambaran');
            $table->integer('no_soal');
            $table->text('deskripsi');
            $table->string('kunci_m');
            $table->string('kunci_l');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gambaran');
    }
}
