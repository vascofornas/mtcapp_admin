<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Email;

use DB;

class EmailsController extends Controller {

	function index(){
		$sql ="SELECT 
			(SELECT email FROM emails WHERE name='consulta_sanitaria') AS consulta_sanitaria,
			(SELECT email FROM emails WHERE name='consulta_movilidad') AS consulta_movilidad,
			(SELECT email FROM emails WHERE name='consulta_juridica') AS consulta_juridica,
			(SELECT email FROM emails WHERE name='consulta_educativa') AS consulta_educativa
		FROM DUAL";

		$emails = DB::selectOne($sql);
        return [
            'emails' => $emails
        ];
	}

}
