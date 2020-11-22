<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('llave');
            $table->smallInteger('id_tramite');
            $table->string('no_solicitud');
            $table->date('fecha_solicitud');
            $table->time('hora_solicitud');
            $table->string('no_solicitud_api');
            $table->date('fecha_solicitud_api');
            $table->time('hora_solicitud_api');
            $table->tinyInteger('id_estado');
            $table->string('id_electronico');
            $table->string('referencia_pago');
            $table->date('fecha_pago');
            $table->time('hora_pago');
            $table->string('stripe_orden_id');
            $table->string('stripe_creado');
            $table->string('stripe_mensaje');
            $table->string('stripe_tipo');
            $table->string('stripe_digitos');
            $table->string('stripe_red');
            $table->string('stripe_estado');
            $table->string('xml_url');
            $table->tinyInteger('no_consulta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
