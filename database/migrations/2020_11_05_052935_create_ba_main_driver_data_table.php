<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaMainDriverDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_main_driver_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('first_name');
            $table->text('last_name');
            $table->date('birthday');
            $table->unsignedBigInteger('nationality');
            $table->string('phone_number');
            $table->string('email');
            $table->unsignedBigInteger('country_id');
            $table->text('city');
            $table->unsignedBigInteger('dl_issue_place');
            $table->date('dl_issued_at');
            $table->date('dl_expires_at');
            $table->unsignedBigInteger('driving_experience_id');
            $table->integer('conviction')->default(0);
            $table->text('comment');
            $table->integer('was_kept_drunk')->default(0);
            $table->integer('grades');
            $table->date('grades_expire_at');
            $table->integer('dtp')->default(0);
            $table->text('driving_license_photos');
            $table->text('passport_photos');
            $table->unsignedBigInteger('ba_request_id');
            $table->timestamps();

            $table->foreign('nationality')->references('id')->on('countries');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('dl_issue_place')->references('id')->on('countries');
            $table->foreign('driving_experience_id')->references('id')->on('driving_experiences');
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
        Schema::dropIfExists('ba_main_driver_data');
    }
}