<?php

namespace App\Http\Controllers;

use PDF;
use App\Permisos;
use Illuminate\Http\Request;
use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PDFController extends Controller
{
    public function PDF(Request $request)
    {
        /*$token = DB::table('tokens')->where('id', 1)->value('token');

        if ($request->ews_token != $token) {
            return response()->json([
                'wps_mensaje' => 'TOKEN invalido o inexistente',
            ], 403);
        }else{*/

            $numero_permiso = DB::table('permisos')->where('folio', $request->ews_no_solicitud)->value('folio');

            if ($numero_permiso == null) {
                return response()->json([
                    'wps_mensaje' => 'Numero de solicitud no encontrada en la Base de Datos',
                ], 400);
            }else{
                $permisos = DB::table('permisos')
                    ->where('folio','=',$request->ews_no_solicitud)
                    ->get();
                
                $pdf = PDF::loadView('pdfpermiso', compact('permisos'));
                return $pdf->stream('Permiso_para_realizar_maniobras_de_carga_y_descarga.pdf');
                return QrCode::generate('soy un Qr');
        //}
      //  public function generar_qr()
    //{
      //  return QrCode::generate('soy un Qr');
    //}
            }
        }
}
