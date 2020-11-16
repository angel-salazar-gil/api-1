<?php

namespace App\Http\Controllers;

use App\Permisos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permisos::all();
        return $permisos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$data = Http::get('https://apis.roo.gob.mx/repositorio/api_documentostramite.php?ews_curp=BACG790327HYNSBV05&ews_token=ShvlfefemkTDrwwR4MF2p5nxLdnmaXdiV_7W3cZyevJHC8gLj5UXnvkCEoeNRX7cNNbYk5YQycBnx_BJXqADLz2Nk0xEWUZzZNMKULBc7agNdK9ZBqqzaTAJ1UiBQjvffk_FWCZg1kroBd6ZlIQNhQi8XDhxRVsKm7jwdtr5gmSqzaW76Ypur%20ooyCJR60GLVxwju8&ews_id_tramite=7&=')->json();
        $permiso = Permisos::create($request->all());
        return $permiso;
        /*
        $permiso = new permisos();
        $permiso->marca = $data->wsp_mensaje;
        $permiso->tipo = $data->wsp_curp;
        $permiso->color_vehiculo = $data->wsp_id_documento;
        $permiso->placas = $data->wsp_codigo;
        $permiso->tonelada_maniobra = $data->wsp_tipo_documento;
        $permiso->nombre_chofer = $data->wsp_descripcion_documento;
        $permiso->licencia = $data->wsp_fecha_documento;
        $permiso->persona_razon_social = $data->wsp_estado;
        $permiso->comercio_denominado = $data->wsp_fecha_solicitud;
        $permiso->direccion = $data->wsp_mensaje;
        $permiso->horarios = $data->wsp_curp;
        $permiso->save();*/
        
        //return response()->json(["mensaje" => "pago creado correctamente"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function show(Permisos $permisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Permisos $permisos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permisos $permisos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permisos $permisos)
    {
        //
    }
}
