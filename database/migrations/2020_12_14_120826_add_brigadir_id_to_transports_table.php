<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBrigadirIdToTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->unsignedBigInteger('brigadir_id')->nullable()->after('disabled_people_seats');
            $table->foreign('brigadir_id')->references('id')->on('brigadirs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->dropForeign([ 'brigadir_id' ]);
            $table->dropColumn('brigadir_id');
        });
    }
}
