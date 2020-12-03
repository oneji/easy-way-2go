<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovingCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moving_cargos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cargo_type_id');
            $table->double('length');
            $table->double('width');
            $table->double('height');
            $table->double('weight');
            $table->integer('packaging');
            $table->unsignedBigInteger('moving_data_id');
            
            $table->foreign('cargo_type_id')->references('id')->on('cargo_types');
            $table->foreign('moving_data_id')->references('id')->on('moving_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moving_cargos');
    }
}
