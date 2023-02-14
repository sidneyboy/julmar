<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedPurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('Received_purchase_orders');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
            $table->double('unit_cost',15,4);
            $table->double('freight',15,4);
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
        Schema::dropIfExists('received_purchase_order_details');
    }
}
