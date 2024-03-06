<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoDiscountToInvoiceCostAdjustmentsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_cost_adjustment_details', function (Blueprint $table) {
            $table->float('bo_discount',15,4)->nullable();
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
            $table->dropColumn('bo_discount',15,4);
        });
    }
}
