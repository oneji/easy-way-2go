<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaTransportDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_transport_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ba_transport_id');
            $table->string('file_path');
            $table->string('doc_type');
            $table->timestamps();

            $table->foreign('ba_transport_id')->references('id')->on('ba_transports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ba_transport_docs');
    }
}
