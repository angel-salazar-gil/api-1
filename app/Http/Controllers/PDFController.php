<?php

namespace App\Http\Controllers;

use PDF;
use App\Permisos;
use Illuminate\Http\Request;
use DB;

class PDFController extends Controller
{
    public function PDF(Request $request)
    {
        //Validacion del token de la API-3
        $token = DB::table('tokens')->where('id', 1)->value('token');

        if ($request->ews_token != $token) {
            return response()->json([
                'wps_mensaje' => 'TOKEN invalido o inexistente',
            ], 403);
        }else{
            //Validación del numero de solicitud
            $numero_permiso = DB::table('permisos')->where('folio', $request->ews_no_solicitud)->value('folio');

            if ($numero_permiso == null) {
                return response()->json([
                    'wps_mensaje' => 'Numero de solicitud no encontrada en la Base de Datos',
                ], 400);
            }else{
                //Validación de la llave de la solicitud
                $llave = DB::table('solicitudes')->where('no_solicitud_api', $request->ews_no_solicitud)->value('llave');
                
                if ($request->ews_llave != $llave) {
                    return response()->json([
                        'wps_mensaje' => 'Llave de la solicitud invalido o inexistente',
                    ], 400);
                }else{
                    //Validacion del id electronico de la solicitud
                    $id_electronico = DB::table('solicitudes')->where('no_solicitud_api', $request->ews_no_solicitud)->value('id_electronico');
                    
                    if ($request->ews_id_electronico != $id_electronico) {
                        return response()->json([
                            'wps_mensaje' => 'ID electronico de la solicitud invalido o inexistente',
                        ], 400);
                    }else{
                        $permisos = DB::table('permisos')
                        ->where('folio','=',$request->ews_no_solicitud)
                        ->get();
                    
                        $pdf = PDF::loadView('pdfpermiso', compact('permisos'));
                        return $pdf->stream('Permiso_para_realizar_maniobras_de_carga_y_descarga.pdf');
                    }
                }
            }
        }
    }
}
