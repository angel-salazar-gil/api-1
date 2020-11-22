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
        $permiso = new permisos();
        $permiso->marca = $request->marca;
        $permiso->tipo = $request->tipo;
        $permiso->color_vehiculo = $request->color_vehiculo;
        $permiso->placas = $request->placas;
        $permiso->tonelada_maniobra = $request->tonelada_maniobra;
        $permiso->nombre_chofer = $request->nombre_chofer;
        $permiso->licencia = $request->licencia;
        $permiso->persona_razon_social = $request->persona_razon_social;
        $permiso->comercio_denominado = $request->comercio_denominado;
        $permiso->direccion = $request->direccion;
        $permiso->horarios = $request->horarios;
        $permiso->save();
        
        return $request;
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
