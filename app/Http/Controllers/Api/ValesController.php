<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Vale;


class ValesController extends Controller {

	function index(){
		$vales = Vale::select('id','titulo','image','contenido','direccion','telefono','email')->orderBy('created_at','DESC')->where('activo','=',1)->get();
        foreach($vales as &$vale){
            if($vale->image) {
                $vale->image = '/uploads/images/vales/'.$vale->image;
            }
        }
        return [
            'vales' => $vales
        ];
	}
}