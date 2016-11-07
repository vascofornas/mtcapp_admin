<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

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
}