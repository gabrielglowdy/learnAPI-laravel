<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanGarmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_garments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_jenis')->unsigned();
            $table->string('nama_bahan');
            $table->string('desc_bahan');
            $table->timestamps();

            $table->foreign('id_jenis')->references('id')->on('jenis_garments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bahan_garments');
    }
}
