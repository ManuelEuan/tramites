<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_MDV_SUCURSAL', function (Blueprint $table) {
            $table->bigIncrements('PK_SUCU_NIDSUCURSAL');
            //DIRECCION
            $table->string('SUCU_CCALLE');
            $table->integer('SUCU_NNUMERO_INTERIOR')->nullable();
            $table->integer('SUCU_NNUMERO_EXTERIOR');
            $table->integer('SUCU_NCP');
            $table->string('SUCU_CCOLONIA');
            $table->integer('SUCU_NCVECOLONIA');
            $table->string('SUCU_CMUNICIPIO');
            $table->integer('SUCU_NCVEMUNICIPIO');
            $table->string('SUCU_CESTADO');
            $table->integer('SUCU_NCVEESTADO');
            $table->string('SUCU_CPAIS');
            $table->integer('SUCU_NCVEPAIS');

            $table->unsignedBigInteger('SUCU_NIDUSUARIO')->nullable();
            $table->foreign('SUCU_NIDUSUARIO')->references('USUA_NIDUSUARIO')->on('TRAM_MST_USUARIO');

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
        Schema::dropIfExists('TRAM_MDV_SUCURSAL');
    }
}
