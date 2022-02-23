<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->foreignId('prescription_id');
            $table->foreignId('pharma_lab_id');
            $table->json('quote_details')->nullable();
            $table->json('quote_reply')->nullable();
            $table->enum('status', ['0', '1', '2']);
            $table->enum('quote_type', ['0', '1', '2']); // ecommerce,associate,outside
            $table->date('submission_date')->nullable();
            $table->longText('file_path')->nullable();
            $table->enum('type', ['LAB', 'MED']); // LAB for Medicine list , MED for Lab test list
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
        Schema::dropIfExists('quote_requests');
    }
}
