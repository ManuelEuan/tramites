<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_MDV_OPCION', function (Blueprint $table) {
            $table->bigIncrements('PK_OPCI_NIDOPCION');
            $table->unsignedBigInteger('FK_OPCI_NIDPREGUNTA')->nullable();
            $table->foreign('FK_OPCI_NIDPREGUNTA')->references('PK_PREG_NIDPREGUNTA')->on('TRAM_MST_PREGUNTA');
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
        Schema::dropIfExists('TRAM_MDV_OPCION');
    }
}
