<?php


namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ZonaWifi;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataEdit\DataEdit;

use DB;

class ZonasWifiController extends Controller
{
    protected $path = 'zonas-wifi';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//CREATE TABLE `zonas_wifi` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `latitud` DECIMAL(10,8) NOT NULL , `longitud` DECIMAL(10,8) NOT NULL , `nombre` VARCHAR(100) NOT NULL, created_at timestamp NULL, updated_at timestamp NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

        $grid = DataGrid::source(new ZonaWifi());
        $grid->add('nombre', 'Nombre', true); //field name, label, sortable

        $grid->add('latitud', 'Latitud', true);
        $grid->add('longitud', 'Longitud', true);

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="'.url('panel/'.$this->path.'/editar/'.$row->id).'">Editar</a>';
        });

        $grid->link(url('panel/'.$this->path.'/editar/0'), "+ Agregar nueva Zona Wifi", "TR");  //add button
        $grid->orderBy('id','desc'); //default orderby
        $grid->paginate(10); //pagination

        return view('pages.panel.'.$this->path.'.index', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editar($id=0)
    {
        if($id){
            $obj = ZonaWifi::findOrFail($id);
        } else {
            $obj = new ZonaWifi();
        }
        if(!$obj->latitud) $obj->latitud = 40.426175;
        if(!$obj->longitud) $obj->longitud = -3.685144;

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type

        $form->add('mapa','Ubicaci&oacute;n','App\Utils\MapWithKey')
            ->latlon('latitud','longitud')->setKey(env('GOOGLE_MAP_KEY'))->zoom(15)->setMapWidth(700)->setMapHeight(400)
                ->extra('<br />Arrastre el pin a las coordenadas de la Zona Wifi');

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Zona Wifi creada correctamente");
            } else {
                $form->message("Zona Wifi actualizada!");
            }
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear una nueva Zona wifi");

            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/".$form->model->id),"Editar Zona Wifi anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }
}
