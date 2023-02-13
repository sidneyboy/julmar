<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingPrintedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_printed_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('van_selling_printed_id')->unsigned()->index();
            $table->foreign('van_selling_printed_id')->references('id')->on('van_selling_printeds');
            $table->BigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('sales_order_number');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->Integer('quantity');
             $table->Integer('butal_quantity');
            $table->double('amount',15,4);
            $table->double('amount_per_sku',15,4);
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
        Schema::dropIfExists('van_selling_printed_details');
    }
}
