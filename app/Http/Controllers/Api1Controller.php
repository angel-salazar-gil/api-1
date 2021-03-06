<?php

namespace App\Http\Controllers;

use Closure;
use DB;
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
            'ews_curp_sw' => 'required',

            //Datos del interesado
            'ews_color_vehiculo' => 'required',
            'ews_tonelada_maniobra' => 'required',
            'ews_persona_razon_social' => 'required',
            'ews_comercio_denominado' => 'required',
            'ews_direccion' => 'required'
        ]);

        //Creación del ID de la solicitud por parte de la API-1
        $config=['table'=>'solicitudes','length'=>10,'prefix'=>date("Y")];
        $no_solicitud_api = IdGenerator::generate($config) + Solicitudes::count();

        //Creación del numero de folio
        $config=['table'=>'permisos','length'=>10,'prefix'=>date("Y")];
        $folio = IdGenerator::generate($config) + Permisos::count();

        $solicitud = new solicitudes();

        //Captura de los errores en la validacion de campos requeridos
        if($rules->fails())
        {
            //Guardado de los datos de entrada del TOKEN
            $tokenacceso = new tokensaccesos();
            $tokenacceso->fecha = date("Y-m-d");
            $tokenacceso->hora = date("H:i:s", time());
            $tokenacceso->ip = $getip;
            $tokenacceso->dato_clave = $request->ews_curp_sw;
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
            if($request->ews_id_tramite != "115850")
            {
                return response()->json(["wsp_mensaje" => "ID del tramite incorrecto"], 400);
            }
        }

        //Validacion del numero de la solicitud
        $no_solicitud = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('no_solicitud');

        if ($request->ews_no_solicitud == $no_solicitud) {
            return response()->json([
                'wsp_mensaje' => 'El numero de solicitud ya existe en la base de datos',
            ], 400);
        }

        //Validacion de la API-5 Potys
        $validacion = Http::get('https://apis.roo.gob.mx/repositorio/api_requisitoslandingpage.php?ews_curp=' . $request->ews_curp_sw . '&ews_token=UA6H5auaxtDo$xcIMz3aYvpntoeCJC7GQ8abH6cUWYS7tvczbBTY0feM7J4C2Shvlq8bBCJC7GQ8abH6cUWYS7tvczbBTY0feM7J4C2Shvlq8bBcNNbYk5YQycBnx_BJXqADLz2Nk0xEWUZzZNMKK4*d&ews_nid_tramite=115850')['wsp_acreditado'];
        
        if (!$validacion) {
            return response()->json([
                "wsp_mensaje" => "Requisitos no encontrados en la plataforma"
            ], 400);
        }
        //Validacion de los datos de respuesta | API-4 Potys
        $respuesta = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116573&ews_codigo=0008&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c');
        
        if ($respuesta == '{"wsp_mensaje":"El CURP proporcionado no es valido"}')  {
            return response()->json([
                "wsp_mensaje" => "El CURP proporcionado no es valido"
            ], 400);
        }

        if ($respuesta == '{"wsp_mensaje":"El CURP proporsionado no corresponde al propietario del documento"}')  {
            return response()->json([
                "wsp_mensaje" => "Datos no encontrados"
            ], 400);
        }

        //Extraccion de datos de los requisitos subidos | API-4 Potys
        $marca = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116579&ews_codigo=0014&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_vehiculo'];
        $tipo = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116579&ews_codigo=0014&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_modelo'];
        $placas = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116579&ews_codigo=0014&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_numero_placas'];
        $nombre_chofer = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116573&ews_codigo=0008&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_nombre'];
        $primer_apellido = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116573&ews_codigo=0008&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_primer_apellido'];
        $segundo_apellido = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116573&ews_codigo=0008&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_segundo_apellido'];
        $numero_licencia = Http::get('https://apis.roo.gob.mx/repositorio/detalledatosdocumento.php?ews_id_documento=116573&ews_codigo=0008&ews_curp=' . $request->ews_curp_sw . '&ews_token=02e74f10e0327ad868d138f2b4fdd6f090eb8d5ef4ebbd9d00cdd93f40aee8a95092ce6456740f6d39a6ee78d557358de069ea4c9c233d36ff9c7f329bc08ff1dba132f6ab6a3e3d17a8d59e82105f4c')['wsp_numero_licencia'];

        //Asignacion del horario de la maniobra segun el tonelaje
        if($request->ews_tonelada_maniobra < 8){
            $horario = "06:00 A 22:00 HORAS";
        }else{
            $horario = "22:00 A 06:00 HORAS";
        }
        
        //Guardado de los datos de entrada del TOKEN
        $tokenacceso = new tokensaccesos();
        $tokenacceso->fecha = date("Y-m-d");
        $tokenacceso->hora = date("H:i:s", time());
        $tokenacceso->ip = $getip;
        $tokenacceso->dato_clave = $request->ews_curp_sw;
        $tokenacceso->mensaje = "Ciudadano encontrado";
        $tokenacceso->codigo = 200;
        $tokenacceso->token_id = 1;
        $tokenacceso->save();

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

        //Optencion del ID de solicitudes
        $ID = DB::table('solicitudes')->where('no_solicitud', $request->ews_no_solicitud)->value('id_solicitud');

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
        $permiso->folio = $folio;
        $permiso->id_solicitud = $ID;
        $permiso->save();
        
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
                        "0" => "<b>Marca</b>",
                        "1" => $marca
                    ],
                    "2" => (Object)[
                        "0" => "<b>Tipo</b>",
                        "1" => $tipo
                    ],
                    "3" => (Object)[
                        "0" => "<b>Color</b>",
                        "1" => $request->ews_color_vehiculo
                    ],
                    "4" => (Object)[
                        "0" => "<b>Placas</b>",
                        "1" => $placas
                    ],
                    "5" => (Object)[
                        "0" => "<b>Toneladas</b>",
                        "1" => $request->ews_tonelada_maniobra
                    ],
                    "6" => (Object)[
                        "0" => "<b>Nombre del chofer</b>",
                        "1" => $nombre_chofer
                    ],
                    "7" => (Object)[
                        "0" => "<b>Número de licencia</b>",
                        "1" => $numero_licencia
                    ],
                    "8" => (Object)[
                        "0" => "<b>Persona fisica o razón social</b>",
                        "1" => $request->ews_persona_razon_social
                    ],
                    "9" => (Object)[
                        "0" => "<b>Comercio denominado</b>",
                        "1" => $request->ews_comercio_denominado
                    ],
                    "10" => (Object)[
                        "0" => "<b>Drección</b>",
                        "1" => $request->ews_direccion
                    ],
                    "11" => (Object)[
                        "0" => "<b>Horario</b>",
                        "1" => $horario
                    ],
                ]
            ]
        ], 200);
    }
}
