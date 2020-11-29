<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tokensaccesos extends Model
{
    protected $fillable = [
        "fecha",
        "hora",
        "ip",
        "dato_clave",
        "mensaje",
        "codigo",
        "token_id"
    ];
}
