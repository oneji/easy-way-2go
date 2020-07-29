<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registered_on');
            $table->unsignedBigInteger('register_country');
            $table->string('register_city');
            $table->string('car_number');
            $table->date('year');
            $table->date('teh_osmotr_date_from');
            $table->date('teh_osmotr_date_to');
            $table->date('insurance_date_from');
            $table->date('insurance_date_to');
            $table->integer('has_cmr')->default(1);
            $table->integer('passengers_seats');
            $table->string('cubo_metres_available');
            $table->string('kilos_available');
            $table->integer('ok_for_move');
            $table->integer('can_pull_trailer');
            $table->integer('has_trailer');
            $table->integer('pallet_transportation');
            $table->integer('air_conditioner');
            $table->integer('wifi');
            $table->integer('tv_video');
            $table->integer('disabled_people_seats');
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
        Schema::dropIfExists('transports');
    }
}
