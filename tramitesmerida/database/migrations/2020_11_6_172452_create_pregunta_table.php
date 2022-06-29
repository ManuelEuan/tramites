<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_MST_PREGUNTA', function (Blueprint $table) {
            $table->bigIncrements('PK_PREG_NIDPREGUNTA');
            $table->string('PREG_CDESCRIPCION');
            $table->integer('PREG_NTIPO');
            $table->unsignedBigInteger('FK_PREG_NIDFORMULARIO')->nullable();
            $table->foreign('FK_PREG_NIDFORMULARIO')->references('PK_FORM_NIDFORMULARIO')->on('TRAM_MST_FORMULARIO');
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
        Schema::dropIfExists('TRAM_MST_PREGUNTA');
    }
}
