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
            $table->bigInteger('ID_pelamar');
            $table->string('institusi')->nullable();
            $table->string('jenjang');
            $table->string('jurusan')->nullable();
            $table->bigInteger('tahun_awal')->nullable();
            $table->bigInteger('tahun_akhir')->nullable();
            $table->timestamps();
            // $table->string('kota');
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
