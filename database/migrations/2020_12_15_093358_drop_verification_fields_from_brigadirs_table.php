<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropVerificationFieldsFromBrigadirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brigadirs', function (Blueprint $table) {
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
        Schema::table('brigadirs', function (Blueprint $table) {
            $table->integer('verification_code')->nullable();
            $table->integer('verified')->default(0);
            $table->dateTime('phone_number_verified_at')->nullable();
        });
    }
}
