<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->foreignId('quote_request_id');
            $table->foreignId('prescription_id');
            $table->foreignId('pharma_lab_id');
            $table->json('quote_details')->nullable();
            $table->enum('status', ['0', '1', '2']);
            $table->longText('file_path')->nullable();
            $table->boolean('is_pdf_generated')->default(0);
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
        Schema::dropIfExists('quotes');
    }
}
