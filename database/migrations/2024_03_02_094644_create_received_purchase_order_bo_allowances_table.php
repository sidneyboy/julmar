<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedPurchaseOrderBoAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_purchase_order_bo_allowances', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('Received_purchase_orders');
            $table->float('bo_allowance',15,6);
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
        Schema::dropIfExists('received_purchase_order_bo_allowances');
    }
}
