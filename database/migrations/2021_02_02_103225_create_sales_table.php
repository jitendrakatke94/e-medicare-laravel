<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('payout_id');
            $table->string('service');
            $table->enum('type', ['MED', 'LAB', 'DOC']);
            $table->foreignId('payment_id');
            $table->foreignId('type_id');
            $table->foreignId('user_id');
            $table->double('total');
            $table->double('paid')->nullable();
            $table->boolean('payment_complete')->default(0);
            $table->double('tax_amount');
            $table->double('earnings');
            $table->double('payable_to_vendor');
            $table->text('pdf_url')->nullable();
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });

        //         id,
        // date,
        // payout_id
        // service, // direct,indirect
        // type, //laboratory, pharmacy, doctor
        // type_id, // with address
        // patient_id,
        // total_paid,
        // tax,
        // earnings,
        // payable_to_vendor
        // pdf_url

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
