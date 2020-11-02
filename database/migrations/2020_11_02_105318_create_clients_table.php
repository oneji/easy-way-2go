<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('first_name');
            $table->text('last_name');
            $table->integer('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('nationality')->nullable();
            $table->string('phone_number');
            $table->integer('verification_code')->nullable();
            $table->integer('verified')->default(0);
            $table->dateTime('phone_number_verified_at')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('id_card')->nullable();
            $table->date('id_card_expires_at')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expires_at')->nullable();
            $table->string('password');
            $table->string('role')->default('client');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('nationality')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
