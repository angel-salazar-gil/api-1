<?php

namespace App\Http\Middleware;

use Closure;

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
        if (!$request->has("ews_token")) {
            return response()->json([
              'message' => 'Acceso no autorizado',
            ], 401);
          }
      
          if ($request->has("ews_token")) {
            $ews_token = "3FxoIbNWGk5SAGlX6EkLXMy/Ta9YWZeUeGi0MVFFo=AB";
            if ($request->input("ews_token") != $ews_token) {
              return response()->json([
                'message' => 'Acceso no autorizado',
              ], 401);
            }
          }
        return $next($request);
    }
}
