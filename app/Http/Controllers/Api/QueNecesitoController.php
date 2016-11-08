<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class QueNecesitoController extends Controller {

    function index(){
        /* Devolvemos el listado de Tipos de Ubicación */
    }

    function categoria($tipo_organizacion_id=0){
        /* Devolvemos las organizaciones de un Tipo de Organizacion (junto con un conteo de sub organizaciones)  */
    }

    function detalle($organizacion_id=0){
        /* Devolvemos las suborganizaciones de una organizacion, si existen */
    }

}