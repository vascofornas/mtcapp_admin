<?php
namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

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
}