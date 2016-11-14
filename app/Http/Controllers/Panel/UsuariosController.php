<?php

namespace App\Http\Controllers\Panel;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataEdit\DataEdit;

class UsuariosController extends Controller
{
    protected $path = 'usuarios';

    function index(){
        $grid = DataGrid::source(new User());
        $grid->add('name','Nombre', true); //field name, label, sortable
        $grid->add('email', 'Correo Electrónico', true);

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="/panel/'.$this->path.'/editar/'.$row->id.'">Editar</a>';
        });

        $grid->link('/panel/'.$this->path.'/editar/0', "+ Agregar nuevo usuario", "TR");  //add button
        $grid->orderBy('id','desc'); //default orderby
        $grid->paginate(10); //pagination

        return view('pages.panel.'.$this->path.'.index', compact('grid'));
    }

    public function editar($id=0){
        if($id){
            $obj = User::find($id);
        } else {
            $obj = new User();
        }

        //$user = \Auth::user();
        //dd($user);

        $form = DataEdit::source($obj);
        $form->add('name','Nombre', 'text')->rule('required');
        $form->add('email','Correo electr&oacute;nico', 'text')->rule('required|unique:users,email,'.$id);

        $form->add('password','Contraseña', 'password')->rule('min:6');
        $form->add('password_repeat','Repetir contraseña', 'password')->rule('required_with:password');

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Usuario creado correctamente");
            } else {
                $form->message("Usuario actualizado!");
            }
            $form->link("/panel/".$this->path,"Regresar al listado");
            $form->link("/panel/".$this->path."/editar/0","Crear un nuevo usuario");

            if($form->model->id){
                $form->link("/panel/".$this->path."/editar/".$form->model->id,"Editar usuario anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));

    }

}