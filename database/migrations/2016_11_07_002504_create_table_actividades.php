<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActividades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');

            $table->integer('organizacion_id', false, true)->nullable();
            $table->integer('concejalia_id', false, true);
            $table->integer('tipo_actividad_id', false, true);

            $table->string('imagen');

            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin')->nullable();
            $table->timestamps();

            $table->index('concejalia_id');
            $table->index('tipo_actividad_id');
            $table->index('organizacion_id');
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
