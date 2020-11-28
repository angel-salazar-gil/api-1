<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmantes', function (Blueprint $table) {
            $table->increments('id')->nullable();
            $table->string ('nombre_firmante', 50)->nullable();
            $table->string('primer_apellido_firmante', 50)->nullable();
            $table->string('segundo_apellido_firmante', 50)->nullable();
            $table->string('cargo_firmante', 100)->nullable();
            $table->date('fecha_vigencia_firmante')->nullable();
            $table->smallInteger('orden_firmas')->nullable();
            $table->char('estatus_firmante', 1)->nullable();
            $table->string('url_imagen_firmante', 100)->nullable();
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
        Schema::dropIfExists('firmantes');
    }
}
