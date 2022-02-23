<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOTPVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_t_p_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('key', 10);
            $table->enum('type', ['EMAILOTP', 'MOBILEOTP', 'FORGOTEMAIL', 'FORGOTMOBILE', 'NEWEMAILOTP', 'NEWMOBILEOTP']);
            $table->string('otp', 10);
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('o_t_p_verifications');
    }
}
