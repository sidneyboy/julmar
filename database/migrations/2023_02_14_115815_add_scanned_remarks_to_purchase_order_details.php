<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScannedRemarksToPurchaseOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Purchase_order_details', function (Blueprint $table) {
            $table->string('scanned_remarks',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Purchase_order_details', function (Blueprint $table) {
            $table->dropColumn('scanned_remarks',100);
        });
    }
}
