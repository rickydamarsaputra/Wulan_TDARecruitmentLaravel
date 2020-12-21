<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengalamanOrganisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengalaman_organisasi', function (Blueprint $table) {
            $table->id('ID_pengalaman_orgn');
            $table->bigInteger('ID_member');
            $table->string('organisasi');
            $table->string('kota');
            $table->string('posisi');
            $table->bigInteger('tahun_awal');
            $table->bigInteger('tahun_akhir');
            $table->text('deskripsi');
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
        Schema::dropIfExists('pengalaman_organisasi');
    }
}
