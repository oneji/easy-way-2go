<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->unsignedBigInteger('forward_from_country_id')->nullable();
            $table->unsignedBigInteger('forward_to_country_id')->nullable();
            $table->unsignedBigInteger('back_from_country_id')->nullable();
            $table->unsignedBigInteger('back_to_country_id')->nullable();
            $table->string('forward_from_address')->nullable();
            $table->string('forward_to_address')->nullable();
            $table->string('back_from_address')->nullable();
            $table->string('back_to_address')->nullable();

            $table->foreign('forward_from_country_id')->references('id')->on('countries');
            $table->foreign('forward_to_country_id')->references('id')->on('countries');
            $table->foreign('back_from_country_id')->references('id')->on('countries');
            $table->foreign('back_to_country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routes', function (Blueprint $table) {
            $table->dropForeign(['forward_from_country_id']);
            $table->dropForeign(['forward_to_country_id']);
            $table->dropForeign(['back_from_country_id']);
            $table->dropForeign(['back_to_country_id']);

            $table->dropColumn('forward_from_country_id');
            $table->dropColumn('forward_to_country_id');
            $table->dropColumn('back_from_country_id');
            $table->dropColumn('back_to_country_id');
            $table->dropColumn('forward_from_address');
            $table->dropColumn('forward_to_address');
            $table->dropColumn('back_from_address');
            $table->dropColumn('back_to_address');
        });
    }
}
