<?php

namespace App\Http\Middleware;

use Closure;
use App\Tokensaccesos;
use Illuminate\Http\Request;
use App\Helpers\UserSystemInfoHelper;

use App\Http\Controllers\Controller;

class ApikeyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        //Optencion del IP del solicitante
        $getip = UserSystemInfoHelper::get_ip();

        if (!$request->has("ews_token")) {
            //Guardado de los datos de entrada del TOKEN
            $tokenacceso = new tokensaccesos();
            $tokenacceso->fecha = date("Y-m-d");
            $tokenacceso->hora = date("H:i:s", time());
            $tokenacceso->ip = $getip;
            $tokenacceso->dato_clave = $request->ews_curp;
            $tokenacceso->mensaje = "TOKEN invalido o inexistente";
            $tokenacceso->codigo = 403;
            $tokenacceso->token_id = 1;
            $tokenacceso->save();
            return response()->json([
              'wps_mensaje' => 'TOKEN invalido o inexistente',
            ], 403);
          }
      
          if ($request->has("ews_token")) {
            $ews_token = "3FxoIbNWGk5SAGlX6EkLXMy/Ta9YWZeUeGi0MVFFo=AB";
            if ($request->input("ews_token") != $ews_token) {
              //Guardado de los datos de entrada del TOKEN
            $tokenacceso = new tokensaccesos();
            $tokenacceso->fecha = date("Y-m-d");
            $tokenacceso->hora = date("H:i:s", time());
            $tokenacceso->ip = $getip;
            $tokenacceso->dato_clave = $request->ews_curp;
            $tokenacceso->mensaje = "TOKEN invalido o inexistente";
            $tokenacceso->codigo = 403;
            $tokenacceso->token_id = 1;
            $tokenacceso->save();
              return response()->json([
                'wps_mensaje' => 'TOKEN invalido o inexistente',
              ], 403);
            }
          }
        return $next($request);
    }
}
