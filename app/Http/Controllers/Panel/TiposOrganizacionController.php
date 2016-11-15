<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TipoOrganizacion;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataForm\DataForm;
use Zofe\Rapyd\DataEdit\DataEdit;

class TiposOrganizacionController extends Controller
{
    protected $path = 'tipos-organizacion';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(new TipoOrganizacion());
        $grid->add('nombre','Nombre', true); //field name, label, sortable
        //$grid->add('slug','Etiqueta', true);

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="'.url('/panel/'.$this->path.'/editar/'.$row->id).'">Editar</a>';
        });

        $grid->link(url('/panel/'.$this->path.'/editar/0'), "+ Agregar nuevo tipo de organizacion", "TR");  //add button
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
            $obj = TipoOrganizacion::find($id);
        } else {
            $obj = new TipoOrganizacion();
        }

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type
        //$form->add('slug','Etiqueta', 'text')->rule('required'); //validation

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Tipo de organización creado correctamente");
            } else {
                $form->message("Tipo de organización actualizado!");
            }
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear un nuevo tipo de organización");

            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/".$form->model->id),"Editar tipo de organización anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function borrar($id)
    {
        //
    }
}
