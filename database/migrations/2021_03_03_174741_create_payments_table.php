<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->foreignId('user_id');
            $table->foreignId('recepient_id');
            $table->foreignId('type_id');
            $table->string('type'); // order , appointment
            $table->double('total_amount');
            $table->string('payment_status')->default('Not Paid'); //Paid, Not Paid, Refund
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_refund_id')->nullable();
            $table->text('razorpay_signature')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
