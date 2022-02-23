<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuoteRequestsBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->longText('report_path')->nullable()->after('type');
            $table->string('bill_number')->nullable()->after('report_path');
            $table->double('bill_amount')->nullable()->after('bill_number');
            $table->date('bill_date')->nullable()->after('bill_amount');
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
            $table->dropColumn(['report_path', 'bill_number', 'bill_amount', 'bill_date']);
        });
    }
}
