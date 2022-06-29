<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TRAM_CAT_ROL', function (Blueprint $table) {
            $table->bigIncrements('ROL_NIDROL');
            $table->string('ROL_CNOMBRE');
            $table->string('ROL_CDESCRIPCION')->nullable();
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
        Schema::dropIfExists('TRAM_CAT_ROL');
    }
}
