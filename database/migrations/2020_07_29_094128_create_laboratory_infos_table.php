<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratory_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('laboratory_unique_id');
            $table->string('laboratory_name');
            $table->string('alt_mobile_number')->nullable();
            $table->string('alt_country_code')->nullable();
            $table->string('gstin');
            $table->string('lab_reg_number');
            $table->string('lab_issuing_authority');
            $table->date('lab_date_of_issue');
            $table->string('lab_valid_upto');
            $table->string('lab_file_path')->nullable();
            $table->boolean('sample_collection')->default(0);
            $table->decimal('order_amount')->nullable();
            $table->json('lab_tests')->nullable();
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
        Schema::dropIfExists('laboratory_infos');
    }
}
