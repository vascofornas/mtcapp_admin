<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataForm\DataForm;
use Zofe\Rapyd\DataEdit\DataEdit;

use App\Models\TipoActividad;

class TiposActividadController extends Controller
{

    protected $path = 'tipos-actividad';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(new TipoActividad());
        $grid->add('nombre','Nombre', true); //field name, label, sortable
        //$grid->add('slug','Etiqueta', true);

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="/panel/'.$this->path.'/editar/'.$row->id.'">Editar</a>';
        });

        $grid->link('/panel/'.$this->path.'/editar/0', "+ Agregar nuevo tipo de actividad", "TR");  //add button
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
            $obj = TipoActividad::find($id);
        } else {
            $obj = new TipoActividad();
        }

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type
        //$form->add('slug','Etiqueta', 'text')->rule('required'); //validation

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Tipo de Actividad creado correctamente");
            } else {
                $form->message("Tipo de Actividad actualizado!");
            }
            $form->link("/panel/".$this->path,"Regresar al listado");
            $form->link("/panel/".$this->path."/editar/0","Crear un nuevo tipo de actividad");

            if($form->model->id){
                $form->link("/panel/".$this->path."/editar/".$form->model->id,"Editar tipo de actividad anterior");
            }

        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }
}
