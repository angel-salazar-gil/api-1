<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    protected $fillable = [
        "llave",
        "id_tramite",
        "no_solicitud",
        "fecha_solicitud",
        "hora_solicitud",
        "no_solicitud_api",
        "fecha_solicitud_api",
        "hora_solicitud_api",
        "id_estado",
        "id_electronico",
        "referencia_pago",
        "fecha_pago",
        "hora_pago",
        "stripe_orden_id",
        "stripe_creado",
        "stripe_mensaje",
        "stripe_tipo",
        "stripe_digitos",
        "stripe_red",
        "stripe_estado",
        "xml_url",
        "no_consulta"
    ];
}
