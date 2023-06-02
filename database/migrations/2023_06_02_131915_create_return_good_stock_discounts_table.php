<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnGoodStockDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_good_stock_discounts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('return_good_stock_id')->unsigned()->index();
            $table->foreign('return_good_stock_id')->references('id')->on('return_good_stocks');
            $table->double('discount_rate',5,2);
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
        Schema::dropIfExists('return_good_stock_discounts');
    }
}
