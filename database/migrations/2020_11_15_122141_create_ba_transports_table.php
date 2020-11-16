<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_transports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registered_on');
            $table->unsignedBigInteger('register_country');
            $table->text('register_city');
            $table->string('car_number');
            $table->unsignedBigInteger('car_brand_id');
            $table->unsignedBigInteger('car_model_id');
            $table->integer('year');
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
            $table->unsignedBigInteger('ba_request_id');

            $table->foreign('car_brand_id')->references('id')->on('car_brands');
            $table->foreign('car_model_id')->references('id')->on('car_models');
            $table->foreign('ba_request_id')->references('id')->on('ba_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ba_transports');
    }
}
