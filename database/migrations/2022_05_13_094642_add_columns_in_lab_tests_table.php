<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInLabTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->text('short_disc')->after('code')->nullable();
            $table->boolean('rx_required')->default(0)->after('short_disc');
            $table->string('manufacturer')->after('rx_required')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_tests', function (Blueprint $table) {
            $table->dropColumn('short_disc');
            $table->dropColumn('rx_required');
            $table->dropColumn('manufacturer');
        });
    }
}
