<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesIqItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes_iq_item', function (Blueprint $table) {
            $table->id('ID_tiq_item');
            $table->bigInteger('ID_tiq');
            $table->bigInteger('ID_tiq_soal');
            $table->string('nomor');
            $table->string('jawaban');
            $table->string('poin');
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
        Schema::dropIfExists('tes_iq_item');
    }
}
