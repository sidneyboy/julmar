<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkuPriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_price_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->double('unit_cost', 15, 4);
            $table->double('price_1', 15, 4)->nullable();
            $table->double('price_2', 15, 4)->nullable();
            $table->double('price_3', 15, 4)->nullable();
            $table->double('price_4', 15, 4)->nullable();
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
        Schema::dropIfExists('sku_price_histories');
    }
}
