<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('from_country_id');
            $table->string('from_address');
            $table->unsignedBigInteger('to_country_id');
            $table->string('to_address');
            $table->unsignedBigInteger('status_id');
            $table->date('date');
            $table->time('time');
            $table->enum('type', [ 'forward', 'back' ]);
            $table->timestamps();

            $table->foreign('transport_id')->references('id')->on('transports');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->foreign('from_country_id')->references('id')->on('countries');
            $table->foreign('to_country_id')->references('id')->on('countries');
            $table->foreign('status_id')->references('id')->on('order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
