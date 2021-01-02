<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('order_id');
            $table->double('amount');
            $table->enum('type', [ 'income', 'outcome' ]);
            $table->date('date')->default(Carbon::now());
            $table->timestamps();

            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
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
        Schema::dropIfExists('transactions');
    }
}
