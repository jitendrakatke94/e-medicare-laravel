<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email');
            $table->string('username');
            $table->string('country_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->string('password');
            $table->string('user_type')->default('PATIENT');
            //$table->enum('user_type', ['SUPERADMIN', 'ADMIN', 'EMPLOYEE', 'PATIENT', 'DOCTOR', 'PHARMACIST', 'LABORATORY', 'HEALTHASSOCIATE', 'PAYMENTADMIN'])->default('PATIENT');
            //$table->enum('login_type', ['WEB', 'FACEBOOK', 'GOOGLE'])->default('WEB');
            $table->string('login_type')->default('WEB');
            $table->enum('is_active', [0, 1, 2, 3])->default(0); // 0-> not active, 1->active , 2->deactivate 3->for doctor approval changes
            $table->boolean('first_login')->default(0);
            $table->string('profile_photo')->nullable();
            $table->json('role')->nullable();
            $table->string('currency_code')->nullable();
            $table->text('comment')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('timezone')->default('Asia/Calcutta');
            $table->unsignedBigInteger('approved')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deactivated_by')->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
