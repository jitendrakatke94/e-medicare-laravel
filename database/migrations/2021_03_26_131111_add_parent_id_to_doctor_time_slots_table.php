<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentIdToDoctorTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_time_slots', function (Blueprint $table) {
            $table->unsignedBigInteger("parent_id")->nullable()->after("shift");
            $table->foreign('parent_id')->references('id')->on('doctor_time_slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_time_slots', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn("parent_id");
        });
    }
}
