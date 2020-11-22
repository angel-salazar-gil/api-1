<?php

namespace App\Http\Controllers;

use App\Permisos;
use App\Solicitudes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Api1Controller extends Controller
{

    public function store(Request $request)
    {
        $solicitud = new solicitudes();
        $solicitud->no_solicitud_api = $request->ews_no_solicitud;
        $solicitud->llave = $request->ews_llave;
        $solicitud->id_tramite = $request->ews_id_tramite;
        $solicitud->fecha_solicitud = $request->ews_fecha_solicitud_api;
        $solicitud->hora_solicitud = $request->ews_hora_solicitud_api;
        $solicitud->save();

        $permiso = new permisos();
        $permiso->color_vehiculo = $request->ews_color_vehiculo;
        $permiso->tonelada_maniobra = $request->ews_tonelada_maniobra;
        $permiso->licencia = $request->ews_licencia;
        $permiso->persona_razon_social = $request->ews_persona_razon_social;
        $permiso->comercio_denominado = $request->ews_comercio_denominado;
        $permiso->direccion = $request->ews_direccion;
        $permiso->save();

        $no_solicitud_api = $request->ews_no_solicitud;
        $color_vehiculo = $request->ews_color_vehiculo;
        $tonelada_maniobra = $request->ews_tonelada_maniobra;
        $licencia = $request->ews_licencia;
        $persona_razon_social = $request->ews_persona_razon_social;
        $comercio_denominado = $request->ews_comercio_denominado;
        $direccion = $request->ews_direccion;

        if($tonelada_maniobra < 8000){
            $horario = "06:00 A 22:00 HORAS";
        }else{
            $horario = "22:00 A 06:00 HORAS";
        }
        
        return response()->json([
            "wsp_no_solicitud" => "2020-0000000001",
            "wsp_no_solicitud_api" => $no_solicitud_api,
            "wsp_mensaje" => "Datos encontrados de la solicitud",
            "wsp_nivel" => 1,
            "wsp_datos" =>(Object)[
                "0" => (Object)[
                    "0" => (Object)[
                        "0" => "Datos del permiso de carga y descarga"
                    ],
                    "1" => (Object)[
                        "0" => "Marca",
                        "1" => ""
                    ],
                    "2" => (Object)[
                        "0" => "Tipo",
                        "1" => ""
                    ],
                    "3" => (Object)[
                        "0" => "Color",
                        "1" => $color_vehiculo
                    ],
                    "4" => (Object)[
                        "0" => "Placas",
                        "1" => ""
                    ],
                    "5" => (Object)[
                        "0" => "Toneladas",
                        "1" => $tonelada_maniobra
                    ],
                    "6" => (Object)[
                        "0" => "Nombre del chofer",
                        "1" => ""
                    ],
                    "7" => (Object)[
                        "0" => "Número de licencia",
                        "1" => $licencia
                    ],
                    "8" => (Object)[
                        "0" => "Persona fisica o razón social",
                        "1" => $persona_razon_social
                    ],
                    "9" => (Object)[
                        "0" => "Comercio denominado",
                        "1" => $comercio_denominado
                    ],
                    "10" => (Object)[
                        "0" => "Drección",
                        "1" => $direccion
                    ],
                    "11" => (Object)[
                        "0" => "Horario",
                        "1" => $horario
                    ],
                ]
            ]
        ], 200);
    }
}
