<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->string('payout_id');
            $table->enum('cycle', ['WEEKLY', 'MONTHLY']);
            $table->enum('type', ['MED', 'LAB', 'DOC']);
            $table->string('period');
            $table->foreignId('type_id');
            $table->double('total_sales');
            $table->double('earnings');
            $table->double('total_payable');
            $table->double('total_paid')->nullable();
            $table->double('balance')->nullable();
            $table->boolean('status')->default(0);
            $table->text('doc_url')->nullable();
            $table->json('record_ids')->nullable();
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
        Schema::dropIfExists('payouts');
    }
}
