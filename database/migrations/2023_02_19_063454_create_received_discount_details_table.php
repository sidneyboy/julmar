<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedDiscountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_discount_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('received_id')->unsigned()->index()->nullable();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->string('discount_name');
            $table->double('discount_rate',15,4);
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
        Schema::dropIfExists('received_discount_details');
    }
}
