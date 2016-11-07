<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use DB;

class Organizacion extends Model {

    protected $table = 'organizaciones';

    public function tipoOrganizacion(){
        return $this->belongsTo('App\Models\TipoOrganizacion', 'tipo_organizacion_id');
    }

    public function tipoUbicacion(){
        return $this->belongsTo('App\Models\TipoUbicacion', 'tipo_ubicacion_id');
    }

    public function children(){
        return $this->hasMany('App\Models\Organizacion', 'organizacion_padre_id');
    }

    public function actividades(){
        return $this->hasMany('App\Models\Actividad', 'organizacion_id');
    }

    public function parent(){
        return $this->belongsTo('App\Models\Organizacion', 'organizacion_padre_id');
    }

    public static function dameOrganizacionesPadre(){
        $cats = DB::select("SELECT id, nombre FROM organizaciones WHERE organizacion_padre_id IS NULL");
        $rows = [NULL=>'Selecciona una organización base'];
        foreach($cats as $cat){
            $rows[$cat->id] = $cat->nombre;
        }
        return $rows;
    }

}