<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMedTestListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prescription_med_lists', function (Blueprint $table) {
            $table->dropColumn('pharmacy_id');
            $table->boolean('quote_generated')->default(0)->after('medicine_id');
        });
        Schema::table('prescription_test_lists', function (Blueprint $table) {
            $table->dropColumn('laboratory_id');
            $table->boolean('quote_generated')->default(0)->after('lab_test_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prescription_med_lists', function (Blueprint $table) {
            $table->dropColumn('quote_generated');
        });

        Schema::table('prescription_test_lists', function (Blueprint $table) {
            $table->dropColumn('quote_generated');
        });
    }
}
