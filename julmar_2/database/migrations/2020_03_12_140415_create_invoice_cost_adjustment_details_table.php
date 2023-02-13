<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceCostAdjustmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_cost_adjustment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_cost_id')->unsigned()->index();
            $table->foreign('invoice_cost_id')->references('id')->on('invoice_cost_adjustments');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->double('adjustments', 15,4);
            $table->integer('quantity');
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
        Schema::dropIfExists('invoice_cost_adjustment_details');
    }
}
