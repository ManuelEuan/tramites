<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_CAT_PERMISO', function (Blueprint $table) {
            $table->bigIncrements('PERMI_NIDPERMISO');
            $table->string('PERMI_CNOMBRE');
            $table->string('PERMI_CDESCRIPCION')->nullable();
            $table->string('PERMI_CICONO')->nullable();
            $table->string('PERMI_CRUTA')->nullable();
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
        Schema::dropIfExists('TRAM_CAT_PERMISO');
    }
}
