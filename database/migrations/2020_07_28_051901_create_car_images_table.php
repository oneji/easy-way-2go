<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('car_passport')->nullable();
            $table->text('teh_osmotr')->nullable();
            $table->text('insurance')->nullable();
            $table->text('people_license')->nullable();
            $table->text('car_photos')->nullable();
            $table->text('trailer_photos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_images');
    }
}
