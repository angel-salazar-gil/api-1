<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('tipo');
            $table->string('color_vehiculo');
            $table->string('placas');
            $table->string('tonelada_maniobra');
            $table->string('nombre_chofer');
            $table->string('licencia');
            $table->string('persona_razon_social');
            $table->string('comercio_denominado');
            $table->string('direccion');
            $table->string('horarios');
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
        Schema::dropIfExists('permisos');
    }
}
