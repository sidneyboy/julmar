<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrincipalIdToInvoiceCostAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_cost_adjustments', function (Blueprint $table) {
            $table->integer('principal_id')->unsigned()->index()->nullable();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Invoice_cost_adjustments', function (Blueprint $table) {
            $table->dropColumn('principal_id');
        });
    }
}
