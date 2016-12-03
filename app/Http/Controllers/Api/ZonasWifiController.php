<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ZonaWifi;

class ZonasWifiController extends Controller {

    function index(){
        $zonas_wifi = ZonaWifi::select(['nombre','latitud','longitud'])->get();
        return [
            'zonas_wifi' => $zonas_wifi
        ];
    }
}    