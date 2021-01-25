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
            $table->bigInteger("ID_member");
            $table->string('nama_pelamar');
            $table->string('kode_pelamar');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->string("keterangan");
            $table->string('ktp');
            $table->string('sim')->nullable();
            $table->string('document_lain')->nullable();
            $table->string('foto_pelamar');
            $table->string('email');
            $table->string('web_blog')->nullable();
            $table->string('no_hp1');
            $table->string('no_hp2')->nullable();
            $table->string('username_ig')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('username_tw')->nullable();
            $table->string('link_youtube')->nullable();
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
