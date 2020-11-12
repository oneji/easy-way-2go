<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_country');
            $table->text('from_address');
            $table->unsignedBigInteger('to_country');
            $table->text('to_address');
            $table->date('date');
            $table->string('buyer_phone_number')->nullable();
            $table->string('buyer_email')->nullable();
            $table->enum('order_type', [ 'passengers', 'packages', 'moving' ]);
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('from_country')->references('id')->on('countries');
            $table->foreign('to_country')->references('id')->on('countries');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
