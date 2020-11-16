<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDrivingLicensePhotosAndPassportPhotosToDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->text('driving_license_photos')->nullable()->after('dl_expires_at');
            $table->text('passport_photos')->nullable()->after('driving_license_photos');
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
            $table->dropColumn('driving_license_photos');
            $table->dropColumn('passport_photos');
        });
    }
}
