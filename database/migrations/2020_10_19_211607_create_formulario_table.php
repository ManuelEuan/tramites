<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormularioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_MST_FORMULARIO', function (Blueprint $table) {
            $table->bigIncrements('PK_FORM_NIDFORMULARIO');
            $table->string('TRAM_CNOMBRE');
            $table->string('TRAM_CDESCRIPCION');
            $table->integer('PREG_NESTATUS');
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
        Schema::dropIfExists('TRAM_MST_FORMULARIO');
    }
}
