<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropVerificationFieldsFromDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn(['verification_code', 'verified', 'phone_number_verified_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->integer('verification_code')->nullable();
            $table->integer('verified')->default(0);
            $table->dateTime('phone_number_verified_at')->nullable();
        });
    }
}
