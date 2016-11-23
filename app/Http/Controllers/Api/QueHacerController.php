<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Concejalia;
use App\Models\TipoActividad;
use App\Models\Actividad;

use Carbon\Carbon;

class QueHacerController extends Controller {

    /* Devolvemos el listado de concejalias y tipos de actividad disponibles */
    function index(){
        $concejalias = Concejalia::select(['id','nombre'])->orderBy('nombre')->get();
        $tipos_actividad = TipoActividad::select(['id', 'nombre'])->orderBy('nombre')->get();

        foreach($concejalias as &$concejalia){
            $concejalia->url_api = '/api/que-hacer/concejalia/'.$concejalia->id;
        }
        foreach($tipos_actividad as &$tipo_actividad){
            $tipo_actividad->url_api = '/api/que-hacer/tipo-actividad/'.$tipo_actividad->id;
        }
        return [
            'concejalias' => $concejalias,
            'tipos_actividad' => $tipos_actividad
        ];
    }

    function concejalia($id=0){
        /* Devolvemos el listado de actividades que corresponden a una concejalia */
        $actividades = Actividad::select(['actividades.id','titulo','actividades.imagen','fecha_inicio','fecha_fin', 'organizaciones.nombre as organizacion_nombre'])
            ->join('organizaciones', 'organizaciones.id','=','actividades.organizacion_id')
            ->where('concejalia_id','=', $id)->orderBy('titulo')->get();
        return ['actividades'=>$this->prepararActividades($actividades)];
    }

    function tipo_actividad($id=0){
        /* Devolvemos el listado de actividades que corresponden a un tipo de actividad */
        $actividades = Actividad::select(['actividades.id','titulo','actividades.imagen','fecha_inicio','fecha_fin', 'organizaciones.nombre as organizacion_nombre'])
            ->join('organizaciones', 'organizaciones.id','=','actividades.organizacion_id')
            ->where('tipo_actividad_id','=', $id)->orderBy('titulo')->get();
        return ['actividades'=>$this->prepararActividades($actividades)];
    }

    function mes($mes,$anio){
        $mes = (int) $mes;
        $anio = (int) $anio;
        $dia_max = cal_days_in_month(\CAL_GREGORIAN, $mes, $anio);

        $min = Carbon::createFromDate($anio, $mes, 1);
        $max = Carbon::createFromDate($anio, $mes, $dia_max);

        $actividades = Actividad::select(['id','titulo','fecha_inicio','fecha_fin'])
            ->whereBetween('fecha_inicio', [$min->format('Y-m-d')." 23:59:59", $max->format('Y-m-d')." 00:00:00"])
            ->orWhereBetween('fecha_fin', [$min->format('Y-m-d')." 23:59:59", $max->format('Y-m-d')." 00:00:00"])->get();
        return ['actividades'=>$actividades];
    }

    function agenda($fecha){
        /* Devolvemos el listado de actividades que corresponden a una fecha en especial */
        $fecha_ex = explode('-', $fecha);
        if(count($fecha_ex)!=3){
            return [];
        }
        $y = (double)$fecha_ex[0];
        $m = (double)$fecha_ex[1];
        $d = (double)$fecha_ex[2];
        if(count($fecha_ex)!=3  || !checkdate($m,$d,$y)){
            return [];
        }

        if($m < 10) $m = '0'.$m;
        if($d < 10) $d = '0'.$d;

        $actividades = Actividad::select(['actividades.id','titulo','actividades.imagen','fecha_inicio','fecha_fin', 'organizaciones.nombre as organizacion_nombre'])
            ->join('organizaciones', 'organizaciones.id','=','actividades.organizacion_id')
            ->whereRaw( '"'.$y.'-'.$m.'-'.$d.'" BETWEEN DATE(fecha_inicio) AND DATE(fecha_fin)' )
            ->orderBy('titulo')->get();
        return ['actividades'=>$this->prepararActividades($actividades)];
    }

    function detalle($id=0){
        $actividad = Actividad::select(['actividades.id','actividades.descripcion','titulo','actividades.imagen','fecha_inicio','fecha_fin', 'organizaciones.nombre as organizacion_nombre'])
            ->join('organizaciones', 'organizaciones.id','=','actividades.organizacion_id')->findOrFail($id);
        if($actividad->imagen){
            $actividad->imagen = '/uploads/images/actividades/'.$actividad->imagen;
        }
        return $actividad;
    }

    protected function prepararActividades($actividades){
        foreach($actividades as &$actividad){
            if($actividad->imagen) {
                $actividad->imagen = '/uploads/images/actividades/'.$actividad->imagen;
            }
        }        
        return $actividades;
    }

}