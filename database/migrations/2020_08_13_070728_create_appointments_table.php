<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->foreignId('patient_id');
            $table->string('appointment_unique_id');
            $table->foreignId('doctor_time_slots_id')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('registered_user')->default(0);
            $table->enum('consultation_type', ['INCLINIC', 'ONLINE', 'EMERGENCY'])->nullable();
            $table->enum('shift', ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT'])->nullable();
            $table->string('payment_status')->default('Not Paid');
            $table->double('total')->nullable();
            $table->double('commission')->default(0);
            $table->double('tax')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->foreignId('followup_id')->nullable();
            $table->json('patient_info')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
