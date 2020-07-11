<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('tabla')->nullable();
            $table->string('tabla_publico')->nullable();
            $table->string('registro_id')->nullable();
            //$table->string('nombre')->nullable();
            $table->boolean('nuevo')->nullable();
            $table->boolean('editar')->nullable();
            $table->boolean('deshabilitar')->nullable();
            $table->boolean('otro')->nullable();
            $table->json('cambios')->nullable();
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
        Schema::dropIfExists('bitacoras');
    }
}
