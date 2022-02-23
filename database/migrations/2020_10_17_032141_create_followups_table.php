<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id');
            $table->foreignId('doctor_id');
            $table->foreignId('patient_id');
            $table->foreignId('clinic_id');
            $table->foreignId('parent_id')->nullable();
            $table->date('last_vist_date');
            $table->date('followup_date');
            $table->boolean('is_cancelled')->default(0);
            $table->boolean('is_completed')->default(0);
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
        Schema::dropIfExists('followups');
    }
}
