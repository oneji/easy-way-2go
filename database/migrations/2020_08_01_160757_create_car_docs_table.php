<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transport_id');
            $table->string('file_path');
            $table->string('doc_type');
            $table->timestamps();

            $table->foreign('transport_id')->references('id')->on('transports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_docs');
    }
}
