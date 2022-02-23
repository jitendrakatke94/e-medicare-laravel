<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorTimeSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->enum('day', ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY']);
            $table->time('slot_start');
            $table->time('slot_end');
            $table->string('type'); //offline, oncline, call,video
            $table->foreignId('doctor_clinic_id')->nullable();
            $table->enum('shift', ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT'])->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_time_slots');
    }
}
