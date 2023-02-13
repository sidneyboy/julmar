<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingTransferInventoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_transfer_inventory_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('vs_transfer_id')->unsigned()->index();
            $table->foreign('vs_transfer_id')->references('id')->on('van_selling_transfer_inventories');
            $table->string('sku_code');
            $table->string('principal');
            $table->string('description');
            $table->string('unit_of_measurement');
            $table->Integer('quantity');
            $table->double('unit_price',15,4);
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
        Schema::dropIfExists('van_selling_transfer_inventory_details');
    }
}
