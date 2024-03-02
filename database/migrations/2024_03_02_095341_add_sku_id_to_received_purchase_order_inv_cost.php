<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkuIdToReceivedPurchaseOrderInvCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Received_purchase_order_inv_costs', function (Blueprint $table) {
            $table->BigInteger('sku_id')->unsigned()->nullable()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Received_purchase_order_inv_costs', function (Blueprint $table) {
            $table->dropColumn('sku_id');
        });
    }
}
