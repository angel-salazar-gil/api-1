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
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->string('ip')->nullable();
            $table->string('dato_clave')->nullable();
            $table->string('mensaje')->nullable();
            $table->string('codigo')->nullable();
            $table->Integer('token_id')->unsigned();
            //$table->foreign('token_id')->references('id')->on ('tokens');
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
