<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingAdjustmentsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_adjustments_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('vs_adjustments_id')->unsigned()->index();
            $table->foreign('vs_adjustments_id')->references('id')->on('van_selling_adjustments');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->Integer('original_quantity');
            $table->Integer('adjusted_quantity');
            $table->double('price',15,4);
            $table->string('remarks');
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
        Schema::dropIfExists('van_selling_adjustments_details');
    }
}
