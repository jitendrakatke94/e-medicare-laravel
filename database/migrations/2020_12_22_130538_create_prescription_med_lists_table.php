<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionMedListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_med_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id');
            $table->foreignId('medicine_id');
            $table->foreignId('pharmacy_id')->nullable();
            $table->string('dosage')->nullable();
            $table->text('instructions')->nullable();
            $table->string('duration')->nullable();
            $table->integer('no_of_refill')->default(0);
            $table->boolean('substitution_allowed')->default(0);
            $table->string('status');
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('prescription_med_lists');
    }
}
