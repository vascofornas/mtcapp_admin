<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Actividad extends Model {
    use SoftDeletes;

    protected $table = 'actividades';

    public function concejalia(){
        return $this->belongsTo('App\Models\Concejalia', 'concejalia_id');
    }

    public function tipoActividad(){
        return $this->belongsTo('App\Models\TipoActividad', 'tipo_actividad_id');
    }

    public function organizacion(){
        return $this->belongsTo('App\Models\Organizacion', 'organizacion_id');
    }

    public function setFechaFinAttribute($val)
    {
        if(!empty($val)){
            $this->attributes['fecha_fin'] = $val;
        } else {
            unset($this->attributes['fecha_fin']);
        }
    }

}