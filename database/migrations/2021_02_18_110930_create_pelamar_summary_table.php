<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelamarSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelamar_summary', function (Blueprint $table) {
            $table->id('ID_pelamar_summary');
            $table->bigInteger('ID_pelamar');
            $table->bigInteger('ID_interpretasi');
            $table->integer('m_d');
            $table->integer('m_i');
            $table->integer('m_s');
            $table->integer('m_c');
            $table->integer('m_st');
            $table->integer('l_d');
            $table->integer('l_i');
            $table->integer('l_s');
            $table->integer('l_c');
            $table->integer('l_st');
            $table->integer('c_d');
            $table->integer('c_i');
            $table->integer('c_s');
            $table->integer('c_c');
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
        Schema::dropIfExists('pelamar_summary');
    }
}
