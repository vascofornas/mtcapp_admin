<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Email;

use Illuminate\Http\Request;

use App\Mail\AltaSuscripcion;
use App\Mail\BajaSuscripcion;

use Mail;

class SuscripcionesController extends Controller {

	function alta(Request $request){
		$email = $request->input('email');
		$movil = $request->input('movil');

		$response = array();

		if($email || $movil){
			$dest = Email::where('name','=','recepcion_suscribete')->first();
			Mail::to($dest->email)->send(new AltaSuscripcion($email, $movil));

			$response['ok'] = \TRUE;
		}
		return $response;
	}

	function baja(Request $request){
		$email = $request->input('email');
		$movil = $request->input('movil');

		$response = array();

		if($email || $movil){
			$dest = Email::where('name','=','recepcion_suscribete')->first();
			Mail::to($dest->email)->send(new BajaSuscripcion($email, $movil));

			$response['ok'] = \TRUE;
		}
		return $response;
	}

}