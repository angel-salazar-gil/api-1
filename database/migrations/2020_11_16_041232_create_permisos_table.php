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
            $table->string('marca')->nullable();
            $table->string('tipo')->nullable();
            $table->string('color_vehiculo')->nullable();
            $table->string('placas')->nullable();
            $table->string('tonelada_maniobra')->nullable();
            $table->string('nombre_chofer')->nullable();
            $table->string('licencia')->nullable();
            $table->string('persona_razon_social')->nullable();
            $table->string('comercio_denominado')->nullable();
            $table->string('direccion')->nullable();
            $table->string('horarios')->nullable();
            $table->integer('solicitudes_id')->unsigned();
            $table->foreign('solicitudes_id')->references('id')->on ('solicitudes');
            $table->integer('firmantes_id')->unsigned();
            $table->foreign('firmantes_id')->references('id')->on ('firmantes');
            $table->integer('imagenes_pdf_id')->unsigned();
            $table->foreign('imagenes_pdf_id')->references('id')->on ('imagenes_pdf');
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
