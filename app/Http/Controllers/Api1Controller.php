<?php

namespace App\Http\Controllers;

use App\Permisos;
use App\Solicitudes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Api1Controller extends Controller
{

    public function store(Request $request)
    {
        //Validacion de los campos requeridos
        $rules = Validator::make($request->all(),[
            //Datos de plataforma
            'ews_llave' => 'required',
            'ews_id_tramite' => 'required',
            'ews_no_solicitud' => 'required',
            'ews_fecha_solicitud' => 'required',
            'ews_hora_solicitud' => 'required',

            //Datos del interesado
            'ews_curp' => 'required',
            'ews_color_vehiculo' => 'required',
            'ews_tonelada_maniobra' => 'required',
            'ews_persona_razon_social' => 'required',
            'ews_comercio_denominado' => 'required',
            'ews_direccion' => 'required'
        ]);

        //Creación del ID de la solicitud por parte de la API-1
        $config=['table'=>'solicitudes','length'=>15,'prefix'=>date("Y")];
        $no_solicitud_api = IdGenerator::generate($config) + Solicitudes::count();

        //Captura de los errores en la validacion de campos requeridos
        if($rules->fails())
        {
            $solicitud->no_solicitud_api = $no_solicitud_api;
            $solicitud->id_estado = 2;
            $solicitud->save();

            $fieldsWithErrorMessagesArray = $rules->messages()->get('*');
            //return $this->errorResponse($fieldsWithErrorMessagesArray, Response::HTTP_UNPROCESSABLE_ENTITY);
            //Impresion de los campos faltantes
            return response()->json([
                "wps_mensaje" => "La solicitud no fue valida",
                "wsp_campos_faltantes" => $fieldsWithErrorMessagesArray
            ], 400);
        }

        //Validacion del ID del tramite
        if($request->ews_id_tramite != "11")
        {
            return response()->json(["wps_mensaje" => "ID del tramite incorrecto"], 400);
        }

        //Guardado de los datos en la tabla Solicitudes
        $solicitud = new solicitudes();
        $solicitud->llave = $request->ews_llave;
        $solicitud->id_tramite = $request->ews_id_tramite;
        $solicitud->no_solicitud = $request->ews_no_solicitud;
        $solicitud->fecha_solicitud = $request->ews_fecha_solicitud;
        $solicitud->hora_solicitud = $request->ews_hora_solicitud;
        $solicitud->fecha_solicitud_api = date("Y-m-d");
        $solicitud->hora_solicitud_api = date("H:i:s", time());

        $solicitud->no_solicitud_api = $no_solicitud_api;
        $solicitud->id_estado = 1;
        $solicitud->save();

        //Guardado de los datos en la tabla Permisos
        $permiso = new permisos();
        $permiso->color_vehiculo = $request->ews_color_vehiculo;
        $permiso->tonelada_maniobra = $request->ews_tonelada_maniobra;
        $permiso->persona_razon_social = $request->ews_persona_razon_social;
        $permiso->comercio_denominado = $request->ews_comercio_denominado;
        $permiso->direccion = $request->ews_direccion;
        $permiso->save();

        //Asignacion del horario de la maniobra segun el tonelaje
        if($request->ews_tonelada_maniobra < 8000){
            $horario = "06:00 A 22:00 HORAS";
        }else{
            $horario = "22:00 A 06:00 HORAS";
        }
        
        //Salida de los datos correctos
        return response()->json([
            "wsp_no_solicitud" => $request->ews_no_solicitud,
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
                        "1" => $request->ews_color_vehiculo
                    ],
                    "4" => (Object)[
                        "0" => "Placas",
                        "1" => ""
                    ],
                    "5" => (Object)[
                        "0" => "Toneladas",
                        "1" => $request->ews_tonelada_maniobra
                    ],
                    "6" => (Object)[
                        "0" => "Nombre del chofer",
                        "1" => ""
                    ],
                    "7" => (Object)[
                        "0" => "Número de licencia",
                        "1" => ""
                    ],
                    "8" => (Object)[
                        "0" => "Persona fisica o razón social",
                        "1" => $request->ews_persona_razon_social
                    ],
                    "9" => (Object)[
                        "0" => "Comercio denominado",
                        "1" => $request->ews_comercio_denominado
                    ],
                    "10" => (Object)[
                        "0" => "Drección",
                        "1" => $request->ews_direccion
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
