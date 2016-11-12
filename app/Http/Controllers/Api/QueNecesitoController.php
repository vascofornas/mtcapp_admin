<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoOrganizacion;
use App\Models\Organizacion;

class QueNecesitoController extends Controller {

    function index(){
        $tipos_organizacion = TipoOrganizacion::select(['id','nombre'])->orderBy('nombre')->get();

        foreach($tipos_organizacion as &$tipo_organizacion){
            $tipo_organizacion->url_api = '/api/que-necesito/organizaciones/'.$tipo_organizacion->id;
        }

        return [
            'tipos_organizacion' => $tipos_organizacion
        ];

    }

    function organizaciones($tipo_organizacion_id=0){
        $organizaciones = Organizacion::where('tipo_organizacion_id','=',$tipo_organizacion_id)
            ->selectRaw('*, (SELECT COUNT(*) FROM organizaciones AS o WHERE o.organizacion_padre_id = organizaciones.id) AS numero_hijos')
            ->get();
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