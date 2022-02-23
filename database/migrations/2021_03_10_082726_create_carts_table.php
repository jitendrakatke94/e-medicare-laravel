<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->double('tax')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('discount')->nullable();
            $table->foreignId('coupon_id')->nullable();
            $table->double('delivery_charge')->nullable();
            $table->double('total')->nullable();
            $table->enum('type', ['LAB', 'MED'])->nullable();
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
        Schema::dropIfExists('carts');
    }
}
