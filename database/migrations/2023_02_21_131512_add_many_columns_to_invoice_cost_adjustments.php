<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToInvoiceCostAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_cost_adjustments', function (Blueprint $table) {
            $table->double('gross_purchase', 15, 4);
            $table->double('total_less_discount', 15, 4);
            $table->double('bo_discount', 15, 4);
            $table->double('vatable_purchase', 15, 4);
            $table->double('vat', 15, 4);
            $table->double('freight', 15, 4);
            $table->double('total_final_cost', 15, 4);
            $table->double('total_less_other_discount', 15, 4)->nullable();
            $table->double('net_payable', 15, 4)->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
            $table->dropColumn('gross_purchase', 15, 4);
            $table->dropColumn('total_less_discount', 15, 4);
            $table->dropColumn('bo_discount', 15, 4);
            $table->dropColumn('vatable_purchase', 15, 4);
            $table->dropColumn('vat', 15, 4);
            $table->dropColumn('freight', 15, 4);
            $table->dropColumn('total_final_cost', 15, 4);
            $table->dropColumn('total_less_other_discount', 15, 4);
            $table->dropColumn('net_payable', 15, 4);
            $table->dropColumn('user_id');
        });
    }
}
