<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaFirmOwnerDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_firm_owner_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('company_name');
            $table->string('inn');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->unsignedBigInteger('nationality');
            $table->date('birthday');
            $table->unsignedBigInteger('country_id');
            $table->text('city');
            $table->text('passport_photo');
            $table->unsignedBigInteger('ba_request_id');
            $table->timestamps();

            $table->foreign('nationality')->references('id')->on('countries');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('ba_request_id')->references('id')->on('ba_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ba_firm_owner_data');
    }
}
