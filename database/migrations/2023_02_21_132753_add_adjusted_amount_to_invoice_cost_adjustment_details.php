<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdjustedAmountToInvoiceCostAdjustmentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_cost_adjustment_details', function (Blueprint $table) {
            $table->double('original_unit_cost',15,4)->nullable();
            $table->double('adjusted_amount',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Invoice_cost_adjustment_details', function (Blueprint $table) {
            $table->dropColumn('original_unit_cost',15,4);
            $table->dropColumn('adjusted_amount',15,4);
        });
    }
}
