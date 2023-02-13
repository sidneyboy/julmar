<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuAddDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_add_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->string('discounts');
            $table->integer('quantity');
            $table->double('freight', 15,4);
            $table->double('unit_cost', 15,4);
            $table->double('final_unit_cost', 15,4);
            $table->integer('quantity_return');
            $table->string('expiration_date',20);
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
        Schema::dropIfExists('sku_add_details');
    }
}
