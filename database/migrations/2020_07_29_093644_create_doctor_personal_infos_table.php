<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('doctor_unique_id');
            $table->string('title')->default('Dr.');
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHERS'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->float('age')->nullable();
            $table->string('qualification')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('alt_country_code')->nullable();
            $table->string('alt_mobile_number')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('career_profile')->nullable();
            $table->string('education_training')->nullable();
            $table->string('experience')->nullable();
            $table->string('clinical_focus')->nullable();
            $table->string('awards_achievements')->nullable();
            $table->string('memberships')->nullable();
            $table->boolean('appointment_type_online')->nullable();
            $table->boolean('appointment_type_offline')->nullable();
            $table->double('consulting_online_fee')->nullable();
            $table->double('consulting_offline_fee')->nullable();
            $table->double('emergency_fee')->nullable();
            $table->integer('emergency_appointment')->nullable();
            $table->dateTime('available_from_time')->nullable();
            $table->dateTime('available_to_time')->nullable();
            $table->string('service')->nullable();
            $table->integer('no_of_followup')->nullable();
            $table->integer('followups_after')->nullable();
            $table->integer('cancel_time_period')->nullable();
            $table->integer('reschedule_time_period')->nullable();
            $table->boolean('payout_period')->default(0);
            $table->string('registration_number')->nullable();
            $table->integer('time_intravel')->default(10);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deactivated_by')->nullable();
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
        Schema::dropIfExists('doctor_personal_infos');
    }
}
