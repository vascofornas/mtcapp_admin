<?php
namespace App\Http\Controllers\Panel;

use App\Models\Concejalia;
use App\Models\TipoActividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vale;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataEdit\DataEdit;

use DB;

class ValesController extends Controller {

    protected $path = 'vales';

	function index(){
		
		/*
        "CREATE TABLE `vales` (
		 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		 `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		 `image` varchar(255) COLLATE utf8_unicode_ci NULL,
		 `direccion` varchar(255) COLLATE utf8_unicode_ci NULL,
		 `telefono` varchar(255) COLLATE utf8_unicode_ci NULL,
		 `email` varchar(255) COLLATE utf8_unicode_ci NULL,
		 `contenido` text NULL DEFAULT NULL,
		 `activo` tinyint unsigned NOT NULL DEFAULT 1,
		 `created_at` timestamp NULL DEFAULT NULL,
		 `updated_at` timestamp NULL DEFAULT NULL,
		 PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        */

        $grid = DataGrid::source(new Vale());
        //$grid->add('name','Nombre', true); //field name, label, sortable
        $grid->add('titulo','Título', true);
        $grid->add('image', 'Imagen')->cell( function($value, $row) {
            return $value ? '<img src="'.asset('/uploads/images/vales/'.$value).'" width="160" height="80" />' : '';
        });
        $grid->add('created_at', 'Creado en', true);
        $grid->add('activo','Activo?')->cell( function($value, $row){
        	return $value? 'Disponible':'Deshabilitado';
        });

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="'.url('/panel/'.$this->path.'/editar/'.$row->id).'">Editar</a>';
        });

        $grid->link(url('/panel/'.$this->path.'/editar/0'), "+ Agregar nuevo vale de descuento", "TR");  //add button
        $grid->orderBy('created_at','desc'); //default orderby
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
            $obj = Vale::findOrFail($id);
        } else {
            $obj = new Vale();
        }

        $form = DataEdit::source($obj);
        $form->add('titulo','Título', 'text')->rule('required');

    	$form->add('activo','Vale activo?','checkbox');

        $form->add('direccion','Dirección', 'text');
        $form->add('telefono','Teléfono', 'text');
        $form->add('image','Imagen', 'image')->move('uploads/images/vales/')->preview(160,80)->fit(640,320)
            ->extra('<br />Tamaño mínimo: 640 x 320');
    	$form->add('contenido', 'Contenido', 'textarea')->rule('required');
    	$form->add('email','E-mail', 'text')->rule('email');



        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Vale de descuento creado correctamente");
            } else {
                $form->message("Vale de descuento actualizado!");
            }
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear un nuevo vale");
            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/".$form->model->id),"Editar vale de descuento anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));


    } 

}