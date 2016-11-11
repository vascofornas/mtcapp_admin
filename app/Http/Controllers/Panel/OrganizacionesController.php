<?php

namespace App\Http\Controllers\Panel;

use App\Models\TipoOrganizacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\DataGrid\DataGrid;
use Zofe\Rapyd\DataForm\DataForm;
use Zofe\Rapyd\DataEdit\DataEdit;

use App\Models\TipoUbicacion;
use App\Models\Organizacion;


class OrganizacionesController extends Controller
{
    protected $path = 'organizaciones';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = DataGrid::source( new Organizacion() );
        $grid->add('nombre','Nombre', true); //field name, label, sortable
        $grid->add('direccion', 'Direcci&oacute;n', true);

        $grid->add('imagen', 'Imagen')->cell( function($value, $row) {
            return $value ? '<img src="/uploads/images/organizaciones/'.$value.'" width="80" height="80" />' : '';
        });

        //O(n) something
        $grid->add('organizacion_id', 'Organización Base')->cell(function($value, $row){
            return $row->parent ? $row->parent->nombre : '';
        });
        $grid->add('tipo_ubicacion_id', 'Tipo Ubicación')->cell(function($value, $row){
            return $row->tipoUbicacion ? $row->tipoUbicacion->nombre : '';
        });
        $grid->add('tipo_organizacion_id', 'Tipo Organización')->cell(function($value, $row){
            return $row->tipoOrganizacion ? $row->tipoOrganizacion->nombre : '';
        });
        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="/panel/'.$this->path.'/editar/'.$row->id.'">Editar</a>';
        });

        //$grid->link('/panel/'.$this->path.'/suborganizaciones', "Listado de Sub-Organizaciones", "TR");  //add button
        $grid->link('/panel/'.$this->path.'/editar/0', "+ Agregar nueva Organización", "TR");  //add button
        //$grid->link('/panel/'.$this->path.'/suborganizacion/0', "+ Agregar nueva Sub-Organización", "TR");  //add button
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
            $obj = Organizacion::find($id);
        } else {
            $obj = new Organizacion();
        }
        if(!$obj->latitud) $obj->latitud = 40.426175;
        if(!$obj->longitud) $obj->longitud = -3.685144;

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type

        $form->add('parent.nombre','Organización Base','autocomplete')->search(['nombre'])
            ->extra('Ingresar texto para buscar una Organización Padre.<br />');
        $form->add('tipo_ubicacion_id', 'Tipo Ubicación', 'select')->options(TipoUbicacion::dameTipos())
            ->extra('Elegir un tipo de Ubicación (Sección ¿Qué Necesito?)');
        $form->add('tipo_organizacion_id', 'Tipo Organización', 'select')->options(TipoOrganizacion::dameTipos())
            ->extra('Elegir un tipo de Organización (Sección ¿Donde Está?)');
        $form->add('mapa','Ubicaci&oacute;n','App\Utils\MapWithKey')
            ->latlon('latitud','longitud')->setKey(env('GOOGLE_MAP_KEY'))->zoom(15)->setMapWidth(700)->setMapHeight(400);
        $form->add('descripcion', 'Descripci&oacute;n','textarea');
        $form->add('direccion', 'Direcci&oacute;n','text')
            ->extra('Para las organizaciones dependientes de una Organización Padre el llenado es opcional');
        $form->add('imagen','Imagen', 'image')->move('uploads/images/organizaciones/')->preview(80,80)->fit(320,320);
        $form->add('url', 'Página Web', 'text');
        $form->add('url_facebook', 'Fan Page de Facebook', 'text');
        $form->add('url_twitter', 'Página de Twitter', 'text');
        $form->add('url_youtube', 'Página del Canal Youtube', 'text');
        $form->add('telefono', 'Teléfono', 'text');
        $form->add('email', 'Correo electrónico', 'text');

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Organización creada correctamente");
            } else {
                $form->message("Organización actualizada!");
            }
            $form->link("/panel/".$this->path,"Regresar al listado");
            $form->link("/panel/".$this->path."/editar/0","Crear una nueva Organización");
            if($form->model->id){
                $form->link("/panel/".$this->path."/editar/".$form->model->id,"Editar organización anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }

    /**
    public function suborganizaciones()
    {
        $grid = DataGrid::source( (new Organizacion())->whereNotNull('organizacion_padre_id') );
        $grid->add('nombre','Nombre', true); //field name, label, sortable
        //$grid->add('slug','Etiqueta', true);
        //$grid->add('direccion', 'Direcci&oacute;n', true);
        //O(n) something
        $grid->add('organizacion_id', 'Organización Base')->cell(function($value, $row){
            return $row->parent ? $row->parent->nombre : '';
        });

        $grid->add('imagen', 'Imagen')->cell( function($value, $row) {
            return $value ? '<img src="/uploads/images/organizaciones/'.$value.'" width="80" height="80" />' : '';
        });

        $grid->add('id','Opciones')->cell( function( $value, $row) {
            return '<a href="/panel/'.$this->path.'/suborganizacion/'.$row->id.'">Editar</a>';
        });

        $grid->link('/panel/'.$this->path, "Listado de Organizaciones", "TR");  //add button
        $grid->link('/panel/'.$this->path.'/suborganizacion/0', "+ Agregar nueva Sub-Organización", "TR");  //add button
        $grid->orderBy('id','desc'); //default orderby
        $grid->paginate(10); //pagination

        return view('pages.panel.'.$this->path.'.index', compact('grid'));
    }

    public function suborganizacion($id=0){
        if($id){
            $obj = Organizacion::find($id);
        } else {
            $obj = new Organizacion();
        }
        if(!$obj->latitud) $obj->latitud = 40.426175;
        if(!$obj->longitud) $obj->longitud = -3.685144;

        $form = DataEdit::source($obj);
        $form->add('nombre','Nombre', 'text')->rule('required'); //field name, label, type

        $form->add('parent.nombre','Organización Base','autocomplete')->search(['nombre'])->extra('Ingresar texto para buscar una Organización Principal');
        //$form->add('organizacion_padre_id', 'Organización Base', 'select')->rule('required')->options(Organizacion::dameOrganizacionesPadre());
        $form->add('mapa','Ubicaci&oacute;n','App\Utils\MapWithKey')
            ->latlon('latitud','longitud')->setKey(env('GOOGLE_MAP_KEY'))->zoom(15)->setMapWidth(700)->setMapHeight(400);
        $form->add('descripcion', 'Descripci&oacute;n','textarea');
        $form->add('direccion', 'Direcci&oacute;n','text');
        $form->add('imagen','Imagen', 'image')->move('uploads/images/organizaciones/')->preview(80,80)->fit(320,320);
        $form->add('url', 'Página Web', 'text');
        $form->add('url_facebook', 'Fan Page de Facebook', 'text');
        $form->add('url_twitter', 'Página de Twitter', 'text');
        $form->add('url_youtube', 'Página del Canal Youtube', 'text');
        $form->add('telefono', 'Teléfono', 'text');
        $form->add('email', 'Correo electrónico', 'text');

        //$form->add('slug','Etiqueta', 'text')->rule('required'); //validation

        $form->saved(function() use ($form, $id)
        {
            if(!$id){
                $form->message("Organización creada correctamente");
            } else {
                $form->message("Organización actualizada!");
            }
            $form->link("/panel/".$this->path."/suborganizaciones","Regresar al listado de Sub-organizaciones");
            $form->link("/panel/".$this->path."/suborganizacion/0","Crear una nueva Sub-Organización");

            if($form->model->id){
                $form->link("/panel/".$this->path."/suborganizacion/".$form->model->id,"Editar Sub-Organización anterior");
            }

        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }
    */
}
