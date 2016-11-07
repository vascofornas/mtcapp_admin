<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTiposUbicacionAlterImagen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_ubicacion', function (Blueprint $table) {
            $table->string('imagen')->nullable()->change();
        });

        Schema::table('organizaciones', function (Blueprint $table) {
            $table->string('imagen')->nullable()->change();
        });

        Schema::table('actividades', function (Blueprint $table) {
            $table->string('imagen')->nullable()->change();
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
