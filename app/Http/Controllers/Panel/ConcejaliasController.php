<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataForm\DataForm;
use Zofe\Rapyd\DataEdit\DataEdit;

use App\Models\Concejalia;

class ConcejaliasController extends Controller
{
    protected $path = 'concejalias';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(new Concejalia());
        $grid->add('nombre','Nombre', true); //field name, label, sortable
        //$grid->add('slug','Etiqueta', true);

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="/panel/concejalias/editar/'.$row->id.'">Editar</a>';
        });
        //$grid->edit('/panel/concejalias/editar', 'Opciones');

        $grid->link('/panel/concejalias/editar/0', "+ Agregar nueva concejal&iacute;a", "TR");  //add button
        $grid->orderBy('id','desc'); //default orderby
        $grid->paginate(10); //pagination

        return view('pages.panel.concejalias.index', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editar($id=0)
    {
        if($id){
            $obj = Concejalia::find($id);
        } else {
            $obj = new Concejalia();
        }

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type
        //$form->add('slug','Etiqueta', 'text')->rule('required'); //validation

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Concejal&iacute;a creada correctamente");
            } else {
                $form->message("Concejal&iacute;a actualizada!");
            }
            $form->link("/panel/concejalias","Regresar al listado");
            $form->link("/panel/concejalias/editar/0","Crear una nueva concejal&iacute;a");

            if($form->model->id){
                $form->link("/panel/concejalias/editar/".$form->model->id,"Editar concejal&iacute;a anterior");
            }
        });

        return view('pages.panel.concejalias.form', compact('form'));
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
