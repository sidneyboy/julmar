<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingInventoryAdjustmentsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_inventory_adjustments_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('vs_inv_adj_id')->unsigned()->index();
            $table->foreign('vs_inv_adj_id')->references('id')->on('van_selling_inventory_adjustments');
            $table->string('sku_code');
            $table->string('description');
            $table->Integer('beg');
            $table->Integer('total_van_load');
            $table->Integer('total_sales');
            $table->Integer('total_adjustments');
            $table->Integer('pcm');
            $table->Integer('end');
            $table->Integer('inventory_adjustments');
            $table->Integer('actual_stocks_on_hand');
            $table->Double('unit_price',15,4);
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
        Schema::dropIfExists('van_selling_inventory_adjustments_details');
    }
}
