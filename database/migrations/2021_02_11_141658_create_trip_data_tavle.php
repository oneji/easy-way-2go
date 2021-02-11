<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripDataTavle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id');
            $table->date('date');
            $table->time('time');
            $table->string('from_address');
            $table->string('to_address');
            $table->unsignedBigInteger('from_country_id');
            $table->unsignedBigInteger('to_country_id');
            $table->enum('type', [ 'forward', 'back' ]);

            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('from_country_id')->references('id')->on('countries');
            $table->foreign('to_country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_data');
    }
}
