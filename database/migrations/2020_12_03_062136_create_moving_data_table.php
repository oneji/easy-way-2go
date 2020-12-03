<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moving_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_floor');
            $table->integer('to_floor');
            $table->time('time');
            $table->integer('movers_count');
            $table->integer('parking');
            $table->string('parking_working_hours')->nullable();
            $table->unsignedBigInteger('order_id');

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moving_data');
    }
}
