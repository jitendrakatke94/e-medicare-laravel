<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('pharmacy_unique_id');
            $table->string('gstin');
            $table->string('dl_number');
            $table->string('dl_issuing_authority');
            $table->date('dl_date_of_issue');
            $table->date('dl_valid_upto');
            $table->string('dl_file_path');
            $table->string('pharmacy_name');
            $table->string('pharmacist_name');
            $table->string('course');
            $table->string('pharmacist_reg_number');
            $table->string('issuing_authority');
            $table->string('alt_mobile_number')->nullable();
            $table->string('alt_country_code')->nullable();
            $table->string('reg_certificate_path');
            $table->date('reg_date');
            $table->string('reg_valid_upto');
            $table->boolean('home_delivery')->default(0);
            $table->decimal('order_amount')->nullable();
            $table->boolean('payout_period')->default(0);
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
        Schema::dropIfExists('pharmacies');
    }
}
