<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendidikanPelamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendidikan_pelamar', function (Blueprint $table) {
            $table->id('ID_pendidikan');
            $table->bigInteger('ID_member');
            $table->enum('tingkat', ['SD', 'SMP', 'SMA/SMK/MA', 'S1', 'S2', 'non formal']);
            $table->string('institusi');
            $table->string('kota');
            $table->string('jurusan');
            $table->bigInteger('tahun_awal');
            $table->bigInteger('tahun_akhir');
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
        Schema::dropIfExists('pendidikan_pelamar');
    }
}