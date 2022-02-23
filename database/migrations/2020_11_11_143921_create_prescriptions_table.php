<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('appointment_id')->nullable();
            $table->string('unique_id');
            $table->enum('type', ['GENERAL', 'EYE', 'DENTAL'])->default('GENERAL');
            $table->json('info')->nullable(); //general prescription will contain following fields
            //symptoms, diagnosis, bp_systolic, bp_diastolic, pulse_rate. body_temp, height,weight ,details_for_pharmacist, note_to_patient, diet_instruction
            //EYE AND DENTAL defined later
            $table->json('medicine_list')->nullable();
            $table->json('test_list')->nullable();
            $table->text('file_path')->nullable();
            $table->boolean('is_quote_generated')->default(0);
            $table->string('purchase_type')->nullable();
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
        Schema::dropIfExists('prescriptions');
    }
}
