<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;
use DB;

class Concejalia extends Model {

    use Sluggable;

    protected $table = 'concejalias';

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
        return $this->hasMany('App\Models\Actividad', 'concejalia_id');
    }

    public static function dameConcejalias(){
        $cats = DB::select("SELECT id, nombre FROM concejalias");
        $rows = [NULL=>'Selecciona una Concejalía'];
        foreach($cats as $cat){
            $rows[$cat->id] = $cat->nombre;
        }
        return $rows;
    }

}