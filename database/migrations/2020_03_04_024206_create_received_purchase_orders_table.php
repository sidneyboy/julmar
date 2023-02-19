<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivedPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('bo_allowance_discount_rate',5,4);
            $table->integer('principal_id')->unsigned()->index()->nullable();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->bigInteger('purchase_order_id')->unsigned()->index();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->string('dr_si')->index();
            $table->string('truck_number')->index();
            $table->string('courier')->index();
            $table->string('invoice_date')->index();
            $table->string('remarks')->index()->nullable();
            $table->date('date')->index()->nullable();
            $table->string('invoice_image');
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
        Schema::dropIfExists('received_purchase_orders');
    }
}
