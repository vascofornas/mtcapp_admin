<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

use DB;

class TipoOrganizacion extends Model {

    use Sluggable;

    protected $table = 'tipos_organizacion';

    public function organizaciones(){
        return $this->hasMany('App\Models\Organizacion', 'organizacion_padre_id');
    }

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

    public static function dameTipos(){
        $cats = DB::select("SELECT id, nombre FROM tipos_organizacion");
        $rows = [NULL=>'Selecciona un tipo de Organización'];
        foreach($cats as $cat){
            $rows[$cat->id] = $cat->nombre;
        }
        return $rows;
    }
}