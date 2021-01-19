<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllowEmailNotificationsToAllUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->integer('allow_email_notifications')->default(0);
        });
        
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('allow_email_notifications')->default(0);
        });
        
        Schema::table('brigadirs', function (Blueprint $table) {
            $table->integer('allow_email_notifications')->default(0);
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
            $table->dropColumn('allow_email_notifications');
        });
        
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('allow_email_notifications');
        });
        
        Schema::table('brigadirs', function (Blueprint $table) {
            $table->dropColumn('allow_email_notifications');
        });
    }
}
