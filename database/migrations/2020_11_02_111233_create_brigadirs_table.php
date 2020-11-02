<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrigadirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brigadirs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('first_name');
            $table->text('last_name');
            $table->integer('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('nationality');
            $table->string('phone_number');
            $table->integer('verification_code')->nullable();
            $table->integer('verified')->default(0);
            $table->dateTime('phone_number_verified_at')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('company_name');
            $table->string('inn');
            $table->string('role')->default('brigadir');
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
        Schema::dropIfExists('brigadirs');
    }
}
