<?php

namespace App\Http\Controllers;

use Closure;
use App\Permisos;
use App\Solicitudes;
use App\Tokensaccesos;
use App\Http\Controllers\Controller;
use App\Helpers\UserSystemInfoHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class Api1Controller extends Controller
{

    public function store(Request $request)
    {
        //Optencion del IP del solicitante
        $getip = UserSystemInfoHelper::get_ip();

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
        $config=['table'=>'solicitudes','length'=>10,'prefix'=>date("Y")];
        $no_solicitud_api = IdGenerator::generate($config) + Solicitudes::count();

        $solicitud = new solicitudes();

        //Captura de los errores en la validacion de campos requeridos
        if($rules->fails())
        {
            //Guardado de los datos de entrada del TOKEN
            $tokenacceso = new tokensaccesos();
            $tokenacceso->fecha = date("Y-m-d");
            $tokenacceso->hora = date("H:i:s", time());
            $tokenacceso->ip = $getip;
            $tokenacceso->dato_clave = $request->ews_curp;
            $tokenacceso->mensaje = "Datos faltantes en el formulario";
            $tokenacceso->codigo = 400;
            $tokenacceso->token_id = 1;
            $tokenacceso->save();

            $fieldsWithErrorMessagesArray = $rules->messages()->get('*');
            //return $this->errorResponse($fieldsWithErrorMessagesArray, Response::HTTP_UNPROCESSABLE_ENTITY);
            //Impresion de los campos faltantes
            return response()->json([
                "wsp_mensaje" => "La solicitud no fue valida",
                "wsp_campos_faltantes" => $fieldsWithErrorMessagesArray
            ], 400);
        }

        //Validacion del ID del tramite
        if($request->ews_id_tramite != "11")
        {
            return response()->json(["wps_mensaje" => "ID del tramite incorrecto"], 400);
        }

        //Validacion de los datos de respuesta | API-4 Potys
        $respuesta = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116046&ews_codigo=0008&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c');
        
        if ($respuesta == '{"wsp_mensaje":"El CURP proporcionado no es valido"}')  {
            return $respuesta;
        }

        //Extraccion de datos de los requisitos subidos | API-4 Potys
        $marca = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116092&ews_codigo=0014&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_vehiculo'];
        $tipo = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116092&ews_codigo=0014&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_modelo'];
        $placas = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116092&ews_codigo=0014&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_numero_placas'];
        $nombre_chofer = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116046&ews_codigo=0008&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_nombre'];
        $primer_apellido = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116046&ews_codigo=0008&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_primer_apellido'];
        $segundo_apellido = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116046&ews_codigo=0008&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_segundo_apellido'];
        $numero_licencia = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116046&ews_codigo=0008&ews_curp=' . $request->ews_curp . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_numero_licencia'];

        //Asignacion del horario de la maniobra segun el tonelaje
        if($request->ews_tonelada_maniobra < 8000){
            $horario = "06:00 A 22:00 HORAS";
        }else{
            $horario = "22:00 A 06:00 HORAS";
        }
        
        //Guardado de los datos de entrada del TOKEN
        $tokenacceso = new tokensaccesos();
        $tokenacceso->fecha = date("Y-m-d");
        $tokenacceso->hora = date("H:i:s", time());
        $tokenacceso->ip = $getip;
        $tokenacceso->dato_clave = $request->ews_curp;
        $tokenacceso->mensaje = "Ciudadano encontrado";
        $tokenacceso->codigo = 200;
        $tokenacceso->token_id = 1;
        $tokenacceso->save();

        //Guardado de los datos en la tabla Permisos
        $permiso = new permisos();
        $permiso->marca = $marca;
        $permiso->tipo = $tipo;
        $permiso->color_vehiculo = $request->ews_color_vehiculo;
        $permiso->placas = $placas;
        $permiso->tonelada_maniobra = $request->ews_tonelada_maniobra;
        $permiso->nombre_chofer = $nombre_chofer;
        $permiso->primer_apellido = $primer_apellido;
        $permiso->segundo_apellido = $segundo_apellido;
        $permiso->licencia = $numero_licencia;
        $permiso->persona_razon_social = $request->ews_persona_razon_social;
        $permiso->comercio_denominado = $request->ews_comercio_denominado;
        $permiso->direccion = $request->ews_direccion;
        $permiso->horarios = $horario;
        $permiso->folio = $no_solicitud_api;
        $permiso->save();

        //Guardado de los datos en la tabla Solicitudes
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
                        "1" => $marca
                    ],
                    "2" => (Object)[
                        "0" => "Tipo",
                        "1" => $tipo
                    ],
                    "3" => (Object)[
                        "0" => "Color",
                        "1" => $request->ews_color_vehiculo
                    ],
                    "4" => (Object)[
                        "0" => "Placas",
                        "1" => $placas
                    ],
                    "5" => (Object)[
                        "0" => "Toneladas",
                        "1" => $request->ews_tonelada_maniobra
                    ],
                    "6" => (Object)[
                        "0" => "Nombre del chofer",
                        "1" => $nombre_chofer
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
