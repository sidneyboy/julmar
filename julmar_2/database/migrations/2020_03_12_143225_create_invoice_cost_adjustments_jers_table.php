<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceCostAdjustmentsJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_cost_adjustments_jers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_cost_id')->unsigned()->index();
            $table->foreign('invoice_cost_id')->references('id')->on('invoice_cost_adjustments');
            $table->double('dr', 15,4);
            $table->double('cr', 15,4);
            $table->date('date')->index();
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
        Schema::dropIfExists('invoice_cost_adjustments_jers');
    }
}
