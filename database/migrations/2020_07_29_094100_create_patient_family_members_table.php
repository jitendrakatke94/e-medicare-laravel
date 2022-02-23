<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('patient_family_id');
            $table->string('title');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHERS']);
            $table->date('date_of_birth');
            $table->integer('age');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->enum('marital_status', ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED'])->nullable();
            $table->string('occupation')->nullable();
            $table->enum('relationship', ['FATHER', 'MOTHER', 'DAUGHTER', 'SON', 'HUSBAND', 'WIFE', 'GRANDFATHER', 'GRANDMOTHER', 'BROTHER', 'OTHERS']);
            $table->string('current_medication')->nullable();
            $table->string('country_code')->nullable();
            $table->string('contact_number')->nullable();
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
        Schema::dropIfExists('patient_family_members');
    }
}
