<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceCostAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_cost_adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->longText('particulars');
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
        Schema::dropIfExists('invoice_cost_adjustments');
    }
}
