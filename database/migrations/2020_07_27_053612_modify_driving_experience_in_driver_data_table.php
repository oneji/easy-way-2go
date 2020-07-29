<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDrivingExperienceInDriverDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_data', function (Blueprint $table) {
            $table->unsignedBigInteger('driving_experience')->nullable()->change();
        
            $table->foreign('driving_experience')->references('id')->on('driving_experiences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driver_data', function (Blueprint $table) {
            $table->dropForeign(['driving_experience']);
            $table->integer('driving_experience')->change();
        });
    }
}
