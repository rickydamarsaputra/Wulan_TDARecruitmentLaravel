<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterpretasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interpretasi', function (Blueprint $table) {
            $table->id('ID_interpretasi');
            $table->string('judul');
            $table->string('dominan_1')->nullable()->default(null);
            $table->string('dominan_2')->nullable()->default(null);
            $table->string('dominan_3')->nullable()->default(null);
            $table->text('deskripsi');
            $table->text('job_match');
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
        Schema::dropIfExists('interpretasi');
    }
}
