<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalUnitCostAndAvgCostToSalesInvoiceDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sales_invoice_details', function (Blueprint $table) {
            $table->float('final_unit_cost', 15, 4)->nullable();
            $table->float('average_cost', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Sales_invoice_details', function (Blueprint $table) {
            $table->dropColumn('final_unit_cost', 15, 4);
            $table->dropColumn('average_cost', 15, 4);
        });
    }
}
