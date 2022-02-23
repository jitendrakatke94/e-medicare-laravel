<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApointmentswithpnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->longText('pns_comment')->nullable()->after('reschedule_by');
            $table->boolean('is_refunded')->nullable()->after('pns_comment');
            $table->double('refund_amount')->nullable()->after('is_refunded');
            $table->boolean('is_valid_pns')->nullable()->after('refund_amount');
            $table->longText('admin_pns_comment')->nullable()->after('is_valid_pns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['pns_comment', 'is_refunded', 'refund_amount', 'is_valid_pns', 'admin_pns_comment']);
        });
    }
}
