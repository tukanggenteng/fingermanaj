<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidikjarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidikjaris', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('nama')->nullable();
          $table->longText('keterangan')->nullable();
          $table->unsignedBigInteger('pegawai_id');
          $table->longText('size');
          $table->longText('valid');
          $table->longText('templatefinger');
          $table->timestamps();

          //$table->unique('templatefinger');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidikjaris');
    }
}
