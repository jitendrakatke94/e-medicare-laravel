<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInDoctorPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_personal_infos', function (Blueprint $table) {
            $table->longText('description')->nullable()->after('is_feature');
            $table->string('area_of_expertise')->nullable()->after('description');
            $table->string('collage_name')->nullable()->after('qualification');
            $table->string('year_of_passing')->nullable()->after('collage_name');
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
            $table->dropColumn('description');
            $table->dropColumn('area_of_expertise');
            $table->dropColumn('collage_name');
            $table->dropColumn('year_of_passing');
        });
    }
}
