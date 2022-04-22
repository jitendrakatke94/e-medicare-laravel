<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndRemoveColomnInDoctorPersonalInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_personal_infos', function (Blueprint $table) {
            $table->json('educations');
            $table->dropColumn(['collage_name', 'year_of_passing']);
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
            $table->dropColumn('educations');
            $table->string('collage_name')->nullable()->after('qualification');
            $table->string('year_of_passing')->nullable()->after('collage_name');
        });
    }
}
