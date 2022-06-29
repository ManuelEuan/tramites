<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTramiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_MST_TRAMITE', function (Blueprint $table) {
            $table->bigIncrements('PK_TRAM_NIDTRAMITE');
            $table->string('TRAM_CNOMBRE');
            $table->enum('TRAM_NTIPO', ['SECRETARÍA', 'ENTIDAD'])->default('SECRETARÍA');
            $table->string('TRAM_CEDIFICIO');
            $table->string('TRAM_CENCARGADO');
            $table->string('TRAM_CCONTACTO');
            $table->string('TRAM_CDESCRIPCION');
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
        Schema::dropIfExists('TRAM_MST_TRAMITE');
    }
}
