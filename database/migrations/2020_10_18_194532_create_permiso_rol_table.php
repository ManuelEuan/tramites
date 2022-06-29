<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_DET_PERMISOROL', function (Blueprint $table) {
            $table->bigIncrements('PROL_NIDPERMISOROL');
            
            $table->unsignedBigInteger('PROL_NIDPERMISO')->nullable();
            $table->foreign('PROL_NIDPERMISO')->references('PERMI_NIDPERMISO')->on('TRAM_CAT_PERMISO');

            $table->unsignedBigInteger('PROL_NIDROL')->nullable();
            $table->foreign('PROL_NIDROL')->references('ROL_NIDROL')->on('TRAM_CAT_ROL');

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
        Schema::dropIfExists('TRAM_DET_PERMISOROL');
    }
}
