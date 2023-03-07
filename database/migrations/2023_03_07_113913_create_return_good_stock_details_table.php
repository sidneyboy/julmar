<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnGoodStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_good_stock_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('return_good_stock_id')->unsigned()->index();
            $table->foreign('return_good_stock_id')->references('id')->on('Return_good_stocks');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
            $table->double('unit_price',15,4)->nullable();
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
        Schema::dropIfExists('return_good_stock_details');
    }
}
