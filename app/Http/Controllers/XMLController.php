<?php

namespace App\Http\Controllers;

use DB;
use app\XML;
use App\Solicitudes;
use Illuminate\Http\Request;

class XMLController extends Controller
{
    public function XML (Request $request)
    {
        //Validacion del TOKEN
        $token = DB::table('tokens')->where('id', 1)->value('token');

        if ($request->ews_token != $token){
            return response()->json([
                'wps_mensaje' => 'TOKEN invalido o inexistente',
            ], 403);
        }

        //Validacion del numero de la solicitud
        $no_solicitud = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('no_solicitud');

        if ($request->ews_no_solicitud != $no_solicitud) {
            return response()->json([
                'wps_mensaje' => 'Numero de solicitud no encontrada en la Base de Datos',
            ], 400);
        }

        //Validación de la llave de la solicitud
        $llave = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('llave');

        if ($request->ews_llave != $llave) {
            return response()->json([
                'wps_mensaje' => 'Llave de la solicitud invalido o inexistente',
            ], 400);
        }

        $url = url('api/xml/' . $request->ews_no_solicitud);

        $affected = DB::table('solicitudes')
              ->where('no_solicitud', $request->ews_no_solicitud)
              ->update([
                  'id_electronico' => $request->ews_id_electronico,
                  'referencia_pago' => $request->ews_referencia_pago,
                  'fecha_pago' => $request->ews_fecha_pago,
                  'hora_pago' => $request->ews_hora_pago,
                  'stripe_orden_id' => $request->ews_stripe_orden_id,
                  'stripe_creado' => $request->ews_stripe_creado,
                  'stripe_mensaje' => $request->ews_stripe_mensaje,
                  'stripe_tipo' => $request->ews_stripe_tipo,
                  'stripe_digitos' => $request->ews_stripe_digitos,
                  'stripe_red' => $request->ews_stripe_red,
                  'stripe_estado' => $request->ews_stripe_estado,
                  'xml_url' => $url
                ]);

        return response()->json([
            'wsp_mensaje' => 'XML Generado',
            'wsp_no_solicitud' => $request->ews_no_solicitud,
            'wsp_no_solicitud_api' => '202000000001',
            'wsp_fecha_generacion' => date("Y-m-d"),
            'wsp_hora_generacion' => date("H:i:s", time()),
            'wsp_url_xml' => $url,
        ], 200);
    }
}
