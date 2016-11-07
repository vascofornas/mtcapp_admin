<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use DB;

class TipoActividad extends Model {

    protected $table = 'tipos_actividad';

    use Sluggable;


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nombre',
                'onUpdate' => true,
                'unique' => true
            ]
        ];
    }

    public function actividades(){
        return $this->hasMany('App\Models\Actividad', 'tipo_actividad_id');
    }

    public static function dameTiposActividad(){
        $cats = DB::select("SELECT id, nombre FROM tipos_actividad");
        $rows = [NULL=>'Selecciona un tipo de Actividad'];
        foreach($cats as $cat){
            $rows[$cat->id] = $cat->nombre;
        }
        return $rows;
    }

}