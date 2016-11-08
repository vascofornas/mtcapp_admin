<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class DondeEstaController extends Controller {

    function index(){
        /* Devolvemos el listado de Tipos de Ubicación */
    }

    function categoria($categoria_id=0){
        /* Devolvemos las subcategorias de un Tipo de Ubicación,
        y el listado de organizaciones (junto con un conteo de sub organizaciones) */
    }

    function detalle($organizacion_id=0){
        /* Devolvemos las suborganizaciones de una organizacion, si existen */
    }

}