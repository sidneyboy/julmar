<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToInvoiceCostAdjustmentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_cost_adjustment_details', function (Blueprint $table) {
            $table->float('amount', 15, 4)->nullable();
            $table->float('discount', 15, 4)->nullable();
            $table->float('bo_allowance', 15, 4)->nullable();
            $table->float('cwo', 15, 4)->nullable();
            $table->float('total_discount', 15, 4)->nullable();
            $table->float('vat', 15, 4)->nullable();
            $table->float('total_cost', 15, 4)->nullable();
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
            $table->dropColumn('amount');
            $table->dropColumn('discount');
            $table->dropColumn('bo_allowance');
            $table->dropColumn('cwo');
            $table->dropColumn('total_discount');
            $table->dropColumn('vat');
            $table->dropColumn('total_cost');
        });
    }
}
