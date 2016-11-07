<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTiposUbicacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_ubicacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_ubicacion_padre_id', false, true)->nullable();
            $table->string('slug')->unique();
            $table->string('nombre');
            $table->timestamps();

            $table->index('tipo_ubicacion_padre_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
