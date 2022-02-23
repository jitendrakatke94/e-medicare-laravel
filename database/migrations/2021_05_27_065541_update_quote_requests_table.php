<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuoteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //quote_requests

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->string('pharma_lab_status')->default('Not Dispensed')->after('status');
            $table->string('bill_path')->nullable()->after('pharma_lab_status');
            $table->json('sample_collect')->nullable()->after('bill_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropColumn(['pharma_lab_status', 'bill_path']);
        });
    }
}
