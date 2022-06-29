<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_MST_USUARIO', function (Blueprint $table) {
            $table->bigIncrements('PK_USUA_NIDUSUARIO');
            $table->enum('USUA_NTIPO_PERSONA', ['FISICA', 'MORAL'])->default('FISICA');
            $table->string('USUA_CRFC', 13);
            $table->string('USUA_CCURP', 18);
            $table->enum('USUA_NTIPO_SEXO', ['M', 'F'])->nullable();
            $table->string('USUA_CRAZON_SOCIAL')->nullable();
            $table->string('USUA_CNOMBRES');
            $table->string('USUA_CPRIMER_APELLIDO');
            $table->string('USUA_CSEGUNDO_APELLIDO')->nullable();

            //DIRECCION
            $table->string('USUA_CCALLE');
            $table->integer('USUA_NNUMERO_INTERIOR')->nullable();
            $table->integer('USUA_NNUMERO_EXTERIOR');
            $table->integer('USUA_NCP');
            $table->string('USUA_CCOLONIA');
            $table->integer('USUA_NCVECOLONIA');
            $table->string('USUA_CMUNICIPIO');
            $table->integer('USUA_NCVEMUNICIPIO');
            $table->string('USUA_CESTADO');
            $table->integer('USUA_NCVEESTADO');
            $table->string('USUA_CPAIS');
            $table->integer('USUA_NCVEPAIS');

            $table->string('USUA_CCORREO_ELECTRONICO');
            $table->string('USUA_CCORREO_ALTERNATIVO')->nullable();
            $table->string('USUA_CCONTRASENIA');

            $table->unsignedBigInteger('FK_USUA_NIDROL')->nullable();
            $table->foreign('FK_USUA_NIDROL')->references('PK_ROL_NIDROL')->on('TRAM_CAT_ROL');

            // No se si pondran roles y permisos
            /* $table->bigInteger('rol_id')->nullable()->unsigned()->index(); */
            
            $table->timestamps();


            //Referencias a las llaves foraneas
            /* $table->foreign('rol_id')->references('id')->on('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade'); */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TRAM_MST_USUARIO');
    }
}
