<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->date('followup_date')->nullable()->after('patient_info');
            $table->integer('cancel_time')->nullable()->after('followup_date');
            $table->integer('reschedule_time')->nullable()->after('cancel_time');
            $table->longText('comment')->nullable()->after('reschedule_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['cancel_time', 'reschedule_time', 'comment', 'followup_date']);
        });
    }
}
