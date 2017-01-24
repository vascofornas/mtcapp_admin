<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Actividad;
use DateTime;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Actividad::saving(function($actividad){
           if(!$actividad->fecha_fin){
                $inicio = strtotime($actividad->fecha_inicio);
                $endOfDay = DateTime::createFromFormat('Y-m-d H:i:s', (new DateTime())->setTimestamp($inicio)->format('Y-m-d 23:59:59'))->format('Y-m-d H:i:s');

                $actividad->fecha_fin = $endOfDay;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
