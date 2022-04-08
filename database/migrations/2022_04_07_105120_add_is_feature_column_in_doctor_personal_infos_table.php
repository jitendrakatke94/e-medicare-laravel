<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeatureColumnInDoctorPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_personal_infos', function (Blueprint $table) {
            $table->boolean('is_feature')->default(0)->after('experience');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_personal_infos', function (Blueprint $table) {
            $table->dropColumn('is_feature');
        });
    }
}