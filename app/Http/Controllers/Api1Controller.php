<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Api1Controller extends Controller
{
    /*
    public function list()
    {
        $data = Http::get('https://apis.roo.gob.mx/repositorio/api_documentostramite.php?ews_curp=BACG790327HYNSBV05&ews_token=ShvlfefemkTDrwwR4MF2p5nxLdnmaXdiV_7W3cZyevJHC8gLj5UXnvkCEoeNRX7cNNbYk5YQycBnx_BJXqADLz2Nk0xEWUZzZNMKULBc7agNdK9ZBqqzaTAJ1UiBQjvffk_FWCZg1kroBd6ZlIQNhQi8XDhxRVsKm7jwdtr5gmSqzaW76Ypur%20ooyCJR60GLVxwju8&ews_id_tramite=7&=')->json();
        return $data;
    }
*/
    public function Api1(Request $request)
    {
        //$hora = "hora";
        //$ews_token = $request->input('ews_token');
        //$ews_no_solicitud = $request->input('ews_no_solicitud');
        //$ews_llave = $request->input('ews_llave');
        $ews_id_tramite = $request->input('ews_id_tramite');
        //$ews_fecha_solicitud = $request->timestamps();
        //$ews_hora_solicitud = $hora;

        $ews_color_vehiculo = $request->input('ews_color_vehiculo');
        $ews_tonelada_maniobra = $request->input('ews_tonelada_maniobra');
        $ews_persona_razon_social = $request->input('ews_persona_razon_social');
        $ews_licencia = $request->input('ews_licencia');
        $ews_comercio_denominado = $request->input('ews_comercio_denominado');
        $ews_direccion = $request->input('ews_direccion');

        return response()->json([$request], 200);
    }
}
