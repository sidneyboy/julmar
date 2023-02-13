<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuPriceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_price_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sku_id');
            $table->double('invoice_cost', 15,4);
            $table->double('price_1', 15,4);
            $table->double('price_2', 15,4);
            $table->double('price_3', 15,4);
            $table->double('price_4', 15,4);
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
        Schema::dropIfExists('sku_price_details');
    }
}
