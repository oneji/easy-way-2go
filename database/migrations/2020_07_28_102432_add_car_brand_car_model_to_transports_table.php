<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarBrandCarModelToTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->unsignedBigInteger('car_brand_id')->after('car_number');
            $table->unsignedBigInteger('car_model_id')->after('car_brand_id');

            $table->foreign('car_brand_id')->references('id')->on('car_brands');
            $table->foreign('car_model_id')->references('id')->on('car_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->dropForeign(['car_brand_id', 'car_model_id']);
            $table->dropColumn('car_brand_id');
            $table->dropColumn('car_model_id');
        });
    }
}
