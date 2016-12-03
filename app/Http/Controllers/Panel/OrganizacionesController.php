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
            return $value ? '<img src="'.asset('/uploads/images/organizaciones/'.$value).'" width="80" height="80" />' : '';
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
            return '<a href="'.url('/panel/'.$this->path.'/editar/'.$row->id).'">Editar</a>';
        });

        //$grid->link('/panel/'.$this->path.'/suborganizaciones', "Listado de Sub-Organizaciones", "TR");  //add button
        $grid->link(url('/panel/'.$this->path.'/editar/0'), "+ Agregar nueva Organización", "TR");  //add button
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
            ->extra('<br />Ingresar texto para buscar una Organización Padre ya existente. (Opcional)
                    <br />Si se llena este valor, el campo Tipo de Organización debe dejarse en blanco');
        $form->add('tipo_ubicacion_id', 'Tipo de Ubicación', 'select')->options(TipoUbicacion::dameTipos())
            ->extra('Elegir un tipo de Ubicación (Para agregar esta Organización actual a la sección ¿Donde Está? de la aplicación)');
        $form->add('tipo_organizacion_id', 'Tipo de Organización', 'select')->options(TipoOrganizacion::dameTipos())
            ->extra('Elegir un tipo de Organización (Para agregar esta Organización actual a la sección ¿Qué Necesito? de la aplicación)');
        $form->add('mapa','Ubicaci&oacute;n','App\Utils\MapWithKey')
            ->latlon('latitud','longitud')->setKey(env('GOOGLE_MAP_KEY'))->zoom(15)->setMapWidth(700)->setMapHeight(400)
            ->extra('<br />Arrastre el pin a las coordenadas de la organización');
        $form->add('descripcion', 'Descripci&oacute;n','textarea');
        $form->add('direccion', 'Direcci&oacute;n','text')
            ->extra('El llenado es opcional para las organizaciones dependientes de una Organización Base');
        $form->add('imagen','Imagen', 'image')->move('uploads/images/organizaciones/')->preview(80,80)->fit(320,320)
            ->extra('<br />Tamaño mínimo: 320 x 320');
        $form->add('url', 'Página Web', 'text')->extraAttributes(['placeholder'=>'http://pagina.com']);
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
            $form->link(url("/panel/".$this->path),"Regresar al listado");
            $form->link(url("/panel/".$this->path."/editar/0"),"Crear una nueva Organización");
            if($form->model->id){
                $form->link(url("/panel/".$this->path."/editar/".$form->model->id),"Editar organización anterior");
            }
        });

        return view('pages.panel.'.$this->path.'.form', compact('form'));
    }
}
