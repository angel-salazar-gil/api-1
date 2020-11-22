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
            $table->string('llave')->nullable();
            $table->smallInteger('id_tramite')->nullable();
            $table->string('no_solicitud')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->time('hora_solicitud')->nullable();
            $table->string('no_solicitud_api')->nullable();
            $table->date('fecha_solicitud_api')->nullable();
            $table->time('hora_solicitud_api')->nullable();
            $table->tinyInteger('id_estado')->nullable();
            $table->string('id_electronico')->nullable();
            $table->string('referencia_pago')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->time('hora_pago')->nullable();
            $table->string('stripe_orden_id')->nullable();
            $table->string('stripe_creado')->nullable();
            $table->string('stripe_mensaje')->nullable();
            $table->string('stripe_tipo')->nullable();
            $table->string('stripe_digitos')->nullable();
            $table->string('stripe_red')->nullable();
            $table->string('stripe_estado')->nullable();
            $table->string('xml_url')->nullable();
            $table->tinyInteger('no_consulta')->nullable();
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
