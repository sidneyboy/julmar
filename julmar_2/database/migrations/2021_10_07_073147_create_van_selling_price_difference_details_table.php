<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingPriceDifferenceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_price_difference_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('vs_price_diff_id')->unsigned()->index();
            $table->foreign('vs_price_diff_id')->references('id')->on('van_selling_price_differences');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->Integer('total_quantity');
            $table->double('price',15,4);
            $table->double('price_update',15,4);
            $table->double('difference');
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
        Schema::dropIfExists('van_selling_price_difference_details');
    }
}
