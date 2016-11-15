<?php

namespace App\Http\Controllers\Panel;

use App\Models\Concejalia;
use App\Models\TipoActividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Actividad;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataEdit\DataEdit;

class ActividadesController extends Controller
{
    protected $path = 'actividades';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(new Actividad());
        $grid->add('titulo','Título', true); //field name, label, sortable

        //$grid->add('concejalia.nombre', 'Concejalía', true);
        //$grid->add('tipoActividad.nombre', 'Tipo de Actividad', true);
        //O(n) something
        $grid->add('concejalia_id', 'Concejalia')->cell(function($value, $row){
            return $row->concejalia ? $row->concejalia->nombre : '';
        });
        $grid->add('tipo_actividad_id', 'Organización Base')->cell(function($value, $row){
            return $row->tipoActividad ? $row->tipoActividad->nombre : '';
        });

        $grid->add('fecha_inicio', 'Fecha de Inicio')->cell(function($value, $row){
            return $value ? date('Y/m/d', strtotime($value)) : '';
        });
        $grid->add('imagen', 'Imagen')->cell( function($value, $row) {
            return $value ? '<img src="'.asset('uploads/images/actividades/'.$value).'" width="80" height="80" />' : '';
        });
        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="'.url('panel/'.$this->path.'/editar/'.$row->id).'">Editar</a>';
        });

        $grid->link(url('panel/'.$this->path.'/editar/0'), "+ Agregar nueva actividad", "TR");  //add button
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
            $obj = Actividad::find($id);
        } else {
            $obj = new Actividad();
        }

        $form = DataEdit::source($obj);
        $form->add('titulo','Título', 'text')->rule('required'); //field name, label, type

        $form->add('concejalia_id', 'Concejalia', 'select')->options(Concejalia::dameConcejalias())->rule('required');
        $form->add('tipo_actividad_id', 'Tipo Actividad', 'select')->options(TipoActividad::dameTiposActividad())->rule('required');
        $form->add('organizacion.nombre','Organización','autocomplete')->search(['nombre'])
            ->extra('<br />Ingresar texto para buscar una Organización ya existente')->rule('required');

        $form->add('imagen','Imagen', 'image')->move('uploads/images/actividades/')->preview(80,80)->fit(320,320);

        if(!$id){
            $form->add('fecha_inicio', 'Fecha de Inicio', 'datetime')->rule('required|after:yesterday');
            $form->add('fecha_fin', 'Fecha Finalización', 'datetime')->rule('after:fecha_inicio');
        } else {
            $form->add('fecha_inicio', 'Fecha de Inicio', 'datetime')->rule('required');
            $form->add('fecha_fin', 'Fecha Finalización', 'datetime')->rule('after:fecha_inicio');
        }

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Actividad creada correctamente");
            } else {
                $form->message("Actividad actualizada!");
            }
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear una nueva actividad");

            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/").$form->model->id,"Editar actividad anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }
}
