<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelamarGambaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelamar_gambaran', function (Blueprint $table) {
            $table->id('ID_pelamar_gambaran');
            $table->bigInteger('ID_pelamar');
            $table->integer('no_soal');
            // $table->string('disc');
            // $table->string('ml');
            $table->bigInteger('ID_gambaran_m');
            $table->bigInteger('ID_gambaran_l');
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
        Schema::dropIfExists('pelamar_gambaran');
    }
}
