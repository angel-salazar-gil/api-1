<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    protected $fillable = [
        "marca",
        "tipo",
        "color_vehiculo",
        "placas",
        "tonelada_maniobra",
        "nombre_chofer",
        "licencia",
        "persona_razon_social",
        "comercio_denominado",
        "direccion",
        "horarios"
    ];
}
