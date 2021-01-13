<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_notification_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', [ 'my_messages', 'my_orders', 'drivers_messages', 'drivers_orders' ]);
            $table->integer('user_id');
            $table->string('user_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_notification_settings');
    }
}
