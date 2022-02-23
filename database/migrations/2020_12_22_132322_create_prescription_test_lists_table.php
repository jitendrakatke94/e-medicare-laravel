<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionTestListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_test_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id');
            $table->foreignId('lab_test_id');
            $table->foreignId('laboratory_id')->nullable();
            $table->text('instructions')->nullable();
            $table->string('status');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('prescription_test_lists');
    }
}
