<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeColumnTypeInEmailNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_notification_settings', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->text('data')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_notification_settings', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->enum('type', [ 'my_messages', 'my_orders', 'drivers_orders', 'drivers_messages' ]);
        });
    }
}
