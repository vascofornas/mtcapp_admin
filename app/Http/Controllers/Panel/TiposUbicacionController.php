<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataForm\DataForm;
use Zofe\Rapyd\DataEdit\DataEdit;

use App\Models\TipoUbicacion;

class TiposUbicacionController extends Controller
{
    protected $path = 'tipos-ubicacion';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source(TipoUbicacion::with('parent'));
        $grid->add('nombre','Nombre', true); //field name, label, sortable
        //$grid->add('slug','Etiqueta', true);
        $grid->add('orderby', 'Orden', true);
        $grid->add('parent.nombre', 'Categor&iacute;a Padre', true);
        $grid->add('imagen', 'Imagen')->cell( function($value, $row) {
           return $value ? '<img src="'.asset('/uploads/images/tipos_ubicacion/'.$value).'" width="80" height="40" />' : '';
        });
        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="'.url('/panel/'.$this->path.'/editar/'.$row->id).'">Editar</a>';
        });

        $grid->link(url('/panel/'.$this->path.'/editar/0'), "+ Agregar nuevo tipo de actividad", "TR");  //add button
        $grid->orderBy('id','asc'); //default orderby
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
            $obj = TipoUbicacion::find($id);
        } else {
            $obj = new TipoUbicacion();
        }

        $categorias_padre = TipoUbicacion::dameCategoriasPadre();

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type
        $form->add('orderby', 'Orden', 'number')->rule('required');
        //$form->add('slug','Etiqueta', 'text')->rule('required'); //validation
        $form->add('imagen','Imagen', 'image')->move('uploads/images/tipos_ubicacion/')->preview(160,80)->fit(320,160);

        $form->add('tipo_ubicacion_padre_id', 'Categoria Padre', 'select')->options($categorias_padre);

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Tipo de Ubicaci&oacute;n creado correctamente");
            } else {
                $form->message("Tipo de Ubicaci&oacute;n actualizado!");
            }
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear un nuevo tipo de ubicaci&oacute;n");

            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/".$form->model->id),"Editar tipo de ubicaci&oacute;n anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }
}
