<?php

namespace App\Http\Middleware;

use Closure;

class ews_token
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
        if (!$request-> has("ews_token")){
            return response()->json([
                'mensaje' => 'Token invalido',
            ], 403);
            }
    
            if (!$request-> has("Ews_token")){
                $ews_tokenn="3FxoIbNWGk+5SAGlX6EkLXMy+/Ta9YWZeUeGi0MVFFo=";
                if (!$request-> has("Ews_token") !=$ews_tokenn){
                    return response()->json([
                        'mensaje' => 'Acceso no autorizado',
                    ], 401);
                 }
       
            }
        return $next($request);
    }
}
