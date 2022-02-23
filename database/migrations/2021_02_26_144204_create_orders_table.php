<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('quote_id');
            $table->double('tax');
            $table->double('subtotal');
            $table->double('discount')->default(0);
            $table->double('delivery_charge')->default(0);
            $table->double('total');
            $table->double('commission')->default(0);
            $table->foreignId('billing_address_id')->nullable();
            $table->foreignId('shipping_address_id')->nullable();
            $table->foreignId('pharma_lab_id');
            $table->enum('type', ['LAB', 'MED']);
            $table->string('payment_status')->default('Not Paid');
            $table->string('delivery_status')->default('Pending');
            $table->text('delivery_info')->nullable();
            $table->text('file_path')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
