<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrganizaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');

            $table->integer('tipo_organizacion_id', false, true)->nullable();
            $table->text('direccion');
            $table->text('descripcion')->nullable();

            $table->decimal('latitud');
            $table->decimal('longitud');

            $table->string('imagen');

            $table->string('url')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_twitter')->nullable();
            $table->string('url_youtube')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();

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
        //
    }
}
