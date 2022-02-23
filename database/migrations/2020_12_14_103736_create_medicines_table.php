<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('composition')->nullable();
            $table->float('weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('medicine_type')->nullable();
            $table->string('drug_type')->nullable();
            $table->integer('qty_per_strip')->nullable();
            $table->double('price_per_strip')->nullable();
            $table->double('rate_per_unit')->nullable();
            $table->boolean('rx_required')->default(0);
            $table->text('short_desc')->nullable();
            $table->text('long_desc')->nullable();
            $table->text('cart_desc')->nullable();
            $table->text('image_name')->nullable();
            $table->text('image_path')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deactivated_by')->nullable();
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
        Schema::dropIfExists('medicines');
    }
}
