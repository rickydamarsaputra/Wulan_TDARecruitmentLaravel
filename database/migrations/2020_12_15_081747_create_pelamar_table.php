<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelamar', function (Blueprint $table) {
            $table->id('ID_pelamar');
            $table->bigInteger("ID_lowongan");
            $table->string('nama_pelamar');
            $table->string('kode_pelamar');
            $table->string("keterangan");
            $table->string('ktp');
            $table->string('sim');
            $table->string('email');
            $table->string('web_blog');
            $table->string('no_hp1');
            $table->string('no_hp2');
            $table->string('username_ig');
            $table->string('link_facebook');
            $table->string('username_tw');
            $table->string('link_youtube');
            $table->integer('status');
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
        Schema::dropIfExists('pelamar');
    }
}
