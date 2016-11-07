<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use DB;

class TipoUbicacion extends Model {

    use Sluggable;

    protected $table = 'tipos_ubicacion';

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

    public function organizaciones(){
        return $this->hasMany('App\Models\Organizacion', 'tipo_ubicacion_id');
    }

    public function children(){
        return $this->hasMany('App\Models\TipoUbicacion', 'tipo_ubicacion_padre_id');
    }

    public function parent(){
        return $this->belongsTo('App\Models\TipoUbicacion', 'tipo_ubicacion_padre_id');
    }

    public static function dameCategoriasPadre(){
        $cats = DB::select("SELECT id, nombre FROM tipos_ubicacion WHERE tipo_ubicacion_padre_id IS NULL");
        $rows = [NULL=>'Selecciona... (Opcional)'];
        foreach($cats as $cat){
            $rows[$cat->id] = $cat->nombre;
        }
        return $rows;
    }

    public static function dameTipos(){
        $cats = DB::select("SELECT id, nombre, tipo_ubicacion_padre_id FROM tipos_ubicacion ORDER BY tipo_ubicacion_padre_id");
        $rows = [NULL=>'Selecciona un tipo de ubicación'];
        foreach($cats as $cat){
            if(!$cat->tipo_ubicacion_padre_id) {
                $rows[$cat->id] = $cat->nombre;
            } else if(isset($rows[$cat->tipo_ubicacion_padre_id])) {
                $rows[$cat->id] = $rows[$cat->tipo_ubicacion_padre_id].' > '. $cat->nombre;
            }

        }
        return $rows;
    }

}