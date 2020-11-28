<?php

namespace App\Http\Controllers;

use PDF;
//use App\Permisos;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function PDF()
    {
        //$permisos = Permisos::all();
        //$permisos = DB::table('permisos')->find(3);
        //return $permisos;

        $pdf = PDF::loadView('pdfpermiso');
        return $pdf->stream('Permiso_para_realizar_maniobras_de_carga_y_descarga.pdf');
    }
}
