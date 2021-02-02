<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->integer('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('nationality')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('verification_code')->nullable();
            $table->integer('verified')->default(0);
            $table->dateTime('phone_number_verified_at')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->text('city')->nullable();
            $table->unsignedBigInteger('dl_issue_place')->nullable();
            $table->date('dl_issued_at')->nullable();
            $table->date('dl_expires_at')->nullable();
            $table->text('docs')->nullable();
            $table->integer('conviction')->default(0);
            $table->text('comment')->nullable();
            $table->integer('dtp')->default(0);
            $table->integer('was_kept_drunk')->default(0);
            $table->integer('grades')->nullable();
            $table->date('grades_expire_at')->nullable();
            $table->unsignedBigInteger('driving_experience_id')->nullable();
            $table->string('role')->default('driver');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nationality')->references('id')->on('countries');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('dl_issue_place')->references('id')->on('countries');
            $table->foreign('driving_experience_id')->references('id')->on('driving_experiences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
