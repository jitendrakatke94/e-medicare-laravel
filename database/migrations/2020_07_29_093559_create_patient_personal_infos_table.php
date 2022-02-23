<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('patient_unique_id');
            $table->string('title')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHERS'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->float('age')->nullable();
            $table->string('blood_group')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->enum('marital_status', ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED'])->nullable();
            $table->string('occupation')->nullable();
            $table->string('alt_country_code')->nullable();
            $table->string('alt_mobile_number')->nullable();
            $table->string('current_medication')->nullable();
            $table->string('bpl_file_number')->nullable();
            $table->string('bpl_file_name')->nullable();
            $table->string('bpl_file_path')->nullable();
            $table->string('national_health_id')->nullable();
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
        Schema::dropIfExists('patient_personal_infos');
    }
}
