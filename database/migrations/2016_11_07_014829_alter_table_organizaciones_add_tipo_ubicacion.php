<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrganizacionesAddTipoUbicacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizaciones', function (Blueprint $table) {
            $table->integer('tipo_ubicacion_id', false, true)->nullable();

            $table->index('tipo_ubicacion_id');
            $table->index('tipo_organizacion_id');
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
