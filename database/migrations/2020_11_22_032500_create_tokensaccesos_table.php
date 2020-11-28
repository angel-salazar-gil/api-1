<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensaccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokensaccesos', function (Blueprint $table) {
            $table->smallInteger('id');
            $table->date('fecha');
            $table->time('hora');
            $table->string('ip');
            $table->string('dato_clave');
            $table->string('mensaje');
            $table->string('codigo');
            $table->Integer('token_id')->unsigned();
            $table->foreign('token_id')->references('id')->on ('tokens');
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
        Schema::dropIfExists('tokensaccesos');
    }
}
