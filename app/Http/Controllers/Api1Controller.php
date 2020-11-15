<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Api1Controller extends Controller
{
    public function Api1(Request $request)
    {
        //$ews_token = $request->input('ews_token');
        //$ews_no_solicitud = $request->input('ews_no_solicitud');
        //$ews_llave = $request->input('ews_llave');
        //$ews_id_tramite = $request->input('ews_id_tramite');
        //$ews_fecha_solicitud = $request->timestamps();
        //$ews_hora_solicitud

        $ews_color_vehiculo = $request->input('ews_color_vehiculo');
        $ews_tonelada_maniobra = $request->input('ews_tonelada_maniobra');
        $ews_persona_razon_social = $request->input('ews_persona_razon_social');
        $ews_licencia = $request->input('ews_licencia');
        $ews_razon_social = $request->input('ews_razon_social');
        $ews_direccion = $request->input('ews_direccion');

        return response()->json([ 
            "mensaje" => "Datos encontrados",
            "wsp_datos" => [
                "datos"
            ]], 200);
    }
}
