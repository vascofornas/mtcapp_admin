<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\TipoUbicacion;
use App\Models\Organizacion;

class DondeEstaController extends Controller {

    function categoria($categoria_id=0){
        $categoria_id = (int) $categoria_id;

        /* Obtenemos el listado de Tipos de Ubicación */
        $qu = TipoUbicacion::select(['id','nombre','imagen']);
        if(!$categoria_id){
            $qu->whereNull('tipo_ubicacion_padre_id');
        } else {
            $qu->where('tipo_ubicacion_padre_id','=', $categoria_id);
        }
        $tipos_ubicacion = $qu->orderBy('nombre')->get();
        foreach($tipos_ubicacion as &$tipo_ubicacion){
            if($tipo_ubicacion->imagen) {
                $tipo_ubicacion->imagen = '/uploads/images/tipos_ubicacion/'.$tipo_ubicacion->imagen;
            }            
            $tipo_ubicacion->url_api = '/api/donde-esta/categoria/'.$tipo_ubicacion->id;
        }

        /* Organizaciones base pertenecientes a una categoría */
        $organizaciones = Organizacion::where('tipo_ubicacion_id','=',$categoria_id)
            ->selectRaw('*, (SELECT COUNT(*) FROM organizaciones AS o WHERE o.organizacion_padre_id = organizaciones.id) AS numero_hijos')
            ->get();
        foreach($organizaciones as &$organizacion){
            $organizacion->url_api = '/api/donde-esta/detalle/'.$organizacion->id;
            if($organizacion->imagen) {
                $organizacion->imagen = '/uploads/images/organizaciones/'.$organizacion->imagen;
            }
        }

        return [
            'tipos_ubicacion'=>$tipos_ubicacion,
            'organizaciones' => $organizaciones
        ];

        /* Devolvemos las subcategorias de un Tipo de Ubicación,
        y el listado de organizaciones (junto con un conteo de sub organizaciones) */
    }

    function detalle($organizacion_id=0){
        /* Devolvemos las suborganizaciones de una organizacion, si existen */
        $organizaciones = Organizacion::where('organizacion_padre_id','=',$organizacion_id)
            ->selectRaw('*, (SELECT COUNT(*) FROM organizaciones AS o WHERE o.organizacion_padre_id = organizaciones.id) AS numero_hijos')
            ->get();
        /* Por si las moscas */
        foreach($organizaciones as &$organizacion){
            $organizacion->url_api = '/api/donde-esta/detalle/'.$organizacion->id;
            if($organizacion->imagen) {
                $organizacion->imagen = '/uploads/images/organizaciones/'.$organizacion->imagen;
            }
        }

        return [
            'organizaciones' => $organizaciones
        ];
    }

}