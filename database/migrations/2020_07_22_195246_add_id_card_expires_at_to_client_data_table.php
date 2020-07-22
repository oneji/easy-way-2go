<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdCardExpiresAtToClientDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->date('id_card_expires_at')->nullable()->after('id_card');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_data', function (Blueprint $table) {
            $table->dropColumn('id_card_expires_at');
        });
    }
}
