<?php
namespace App\Http\Controllers\Panel;

use App\Models\Concejalia;
use App\Models\TipoActividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Email;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataEdit\DataEdit;

use DB;

class EmailsController extends Controller
{

    protected $path = 'emails';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/*
    	DB::statement("CREATE TABLE `emails` (
 `name` varchar(30) NOT NULL,
 `email` varchar(100) NOT NULL,
 UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		*/

        $grid = DataGrid::source(new Email());
        //$grid->add('name','Nombre', true); //field name, label, sortable
        $grid->add('email','E-mail')->cell( function($value, $row){
        	return '<b>'.$row->name . '</b>: ' . $row->email;
        });

        $grid->add('name','Opciones')->cell( function( $value, $row) {
            return '<a href="'.url('/panel/'.$this->path.'/editar/'.$row->name).'">Editar</a>';
        });
        //$grid->edit('/panel/concejalias/editar', 'Opciones');

        $grid->link(url('/panel/'.$this->path.'/editar/0'), "+ Agregar nuevo email", "TR");  //add button
        $grid->orderBy('name','desc'); //default orderby
        $grid->paginate(10); //pagination

        return view('pages.panel.'.$this->path.'.index', compact('grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editar($id='')
    {
        if($id){
            $obj = Email::where('name','=',$id)->first();
        } else {
            $obj = new Email();
        }

        $form = DataEdit::source($obj);
        $form->add('name','Código', 'text')->rule('required|alpha_dash')
        	->extra('ID interno del email. No modificar en emails ya creados!'); //field name, label, type
        $form->add('email','e-mail', 'text')->rule('required|email'); //validation

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Email creado correctamente");
            } else {
                $form->message("Email actualizado!");
            }
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear un nuevo email");

            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/".$form->model->id),"Editar email anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }


}