<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use App\Permisos;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PDFController extends Controller
{
    public function PDF(Request $request)
    {
        //Validacion del token de la API-3
        $token = DB::table('tokens')->where('id', 1)->value('token');

        if ($request->ews_token != $token) {
            return response()->json([
                'wsp_mensaje' => 'TOKEN invalido o inexistente',
            ], 403);
        }else{

            //Validación del numero de solicitud
            $numero_permiso = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('no_solicitud');

            if ($numero_permiso == null) {
                return response()->json([
                    'wsp_mensaje' => 'Numero de solicitud no encontrada en la Base de Datos',
                ], 400);
            }else{

                //Validación de la llave de la solicitud
                $llave = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('llave');
                
                if ($request->ews_llave != $llave) {
                    return response()->json([
                        'wsp_mensaje' => 'Llave de la solicitud invalido o inexistente',
                    ], 400);
                }else{

                    //Validacion del id electronico de la solicitud
                    $id_electronico = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('id_electronico');
                    
                    if ($request->ews_id_electronico != $id_electronico) {
                        return response()->json([
                            'wsp_mensaje' => 'ID electronico de la solicitud invalido o inexistente',
                        ], 400);
                    }else{

                        QrCode::size(300)->generate('https://www.potys.gob.mx/validatramite/?id='.$request->ews_id_electronico, '../public/qrcodes/qrcode.svg');
                        
                        //Creación del numero de consulta
                        $config=['table'=>'permisos','length'=>10,'prefix'=>date("Y")];
                        $folio = IdGenerator::generate($config) + Permisos::count();
                        
                        $affected = DB::table('solicitudes')
                        ->where('no_solicitud', $request->ews_no_solicitud)
                        ->update([
                            'no_consulta' => $folio,
                            ]);
                        
                        //Llamada de los datos en la Base de datos
                        $permisos = DB::table('solicitudes')
                        ->join('permisos', 'solicitudes.id_solicitud', '=', 'permisos.id_solicitud')
                        ->select('*')
                        ->where('solicitudes.no_solicitud','=',$request->ews_no_solicitud)
                        ->get();

                        // Fecha de generación del PDF
                        $affected = DB::table('permisos')
                        ->where('id', $permisos[0]->id)
                        ->update([
                            'fecha_generacion_pdf' => $permisos[0]->fecha_solicitud_api
                            ]);

                        //Llamada de los datos en la Base de datos
                        $permisos = DB::table('solicitudes')
                        ->join('permisos', 'solicitudes.id_solicitud', '=', 'permisos.id_solicitud')
                        ->select('*')
                        ->where('solicitudes.no_solicitud','=',$request->ews_no_solicitud)
                        ->get();
                        
                        $pdf = PDF::loadView('pdfpermiso', compact('permisos'))->setPaper('letter','portrait');
                        // Cambio del estatos del tramite
                        $affected = DB::table('solicitudes')
                        ->where('no_solicitud', $request->ews_no_solicitud)
                        ->update([
                            'id_estado' => 6
                            ]);
                            
                        return $pdf->stream('Permiso_para_realizar_maniobras_de_carga_y_descarga.pdf');
                    }
                }
            }
        }
    }
}
