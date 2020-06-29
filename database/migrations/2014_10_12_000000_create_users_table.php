<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombres');
            $table->string('apellido_paterno')->nullable();;
            $table->string('apellido_materno')->nullable();;
            //$table->boolean('cambioPassword')->nullable();
            //$table->boolean('confirmacionEmail')->nullable();
            $table->string('codigoConfirmacionEmail')->nullable();
            $table->string('codigoConfirmacionPassword')->nullable();
            $table->bigInteger('role_id')->unsigned()->nullable();
            $table->boolean('activo')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
