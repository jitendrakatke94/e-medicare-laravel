<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_caches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->foreignId('address_id');
            $table->foreignId('time_slot_id')->nullable();
            $table->enum('consultation_type', ['INCLINIC', 'ONLINE', 'EMERGENCY'])->nullable();
            $table->date('date');
            $table->enum('shift', ['MORNING', 'AFTERNOON', 'EVENING', 'NIGHT'])->nullable();
            $table->unsignedBigInteger('followup_id')->nullable();
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
        Schema::dropIfExists('app_caches');
    }
}
