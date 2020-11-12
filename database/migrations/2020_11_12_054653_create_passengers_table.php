<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gender');
            $table->text('first_name');
            $table->text('last_name');
            $table->date('birthday');
            $table->unsignedBigInteger('nationality');
            $table->string('id_card');
            $table->string('passport_number');
            $table->date('passport_expires_at');
            $table->unsignedBigInteger('order_id');

            $table->foreign('nationality')->references('id')->on('countries');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengers');
    }
}
