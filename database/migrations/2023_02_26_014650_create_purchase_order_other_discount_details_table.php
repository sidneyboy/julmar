<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderOtherDiscountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_other_discount_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_order_id')->unsigned()->index();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->string('discount_name');
            $table->double('discount_rate', 5, 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_other_discount_details');
    }
}
