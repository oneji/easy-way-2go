<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['from_country_id']);
            $table->dropForeign(['to_country_id']);

            $table->dropColumn('from_country_id');
            $table->dropColumn('from_address');
            $table->dropColumn('to_country_id');
            $table->dropColumn('to_address');
            $table->dropColumn('date');
            $table->dropColumn('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->unsignedBigInteger('from_country_id')->nullable();
            $table->string('from_address')->nullable();
            $table->unsignedBigInteger('to_country_id')->nullable();
            $table->string('to_address')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();

            $table->foreign('from_country_id')->references('id')->on('countries');
            $table->foreign('to_country_id')->references('id')->on('countries');
        });
    }
}
