<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityReturnedToReceivedPurchaseOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Received_purchase_order_details', function (Blueprint $table) {
            $table->integer('quantity_returned')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Received_purchase_order_details', function (Blueprint $table) {
            $table->dropColumn('quantity_returned');
        });
    }
}
