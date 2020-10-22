<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('country_id');
            $table->text('city')->nullable();
            $table->unsignedBigInteger('dl_issue_place')->nullable();
            $table->date('dl_issued_at')->nullable();
            $table->date('dl_expires_at')->nullable();
            $table->integer('driving_experience')->nullable();
            $table->integer('was_kept_drunk')->nullable();
            $table->integer('grades')->nullable();
            $table->date('grades_expire_at')->nullable();

            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('dl_issue_place')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_data');
    }
}
