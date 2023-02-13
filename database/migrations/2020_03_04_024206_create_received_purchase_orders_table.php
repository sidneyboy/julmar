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
            $table->integer('discount_id')->unsigned()->index();
            $table->integer('principal_id')->unsigned()->index()->nullable();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->bigInteger('purchase_order_id')->unsigned()->index();
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->string('dr_si')->index();
            $table->string('truck_number')->index();
            $table->string('courier')->index();
            $table->double('freight', 15,4)->index();
            $table->double('vatable_purchase', 15,4);
            $table->double('less_discount', 15,4);
            $table->double('net_discount', 15,4);
            $table->double('vat_amount', 15,4);
            $table->double('grand_final_total_cost', 15,4);
            $table->double('total_bo_allowance', 15,4);
            $table->double('total_every_discount', 15,4);
            $table->double('total_every_discount_2', 15,4);
            $table->string('invoice_date')->index();
            $table->string('remarks')->index();
            $table->date('date')->index();
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
