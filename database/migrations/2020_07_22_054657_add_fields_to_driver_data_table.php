<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDriverDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driver_data', function (Blueprint $table) {
            $table->integer('conviction')->default(0)->after('driving_experience');
            $table->text('comment')->nullable()->after('conviction');
            $table->integer('dtp')->default(0)->after('was_kept_drunk');
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
            $table->dropColumn('conviction');
            $table->dropColumn('comment');
            $table->dropColumn('dtp');
        });
    }
}
