<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToPurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Purchase_orders', function (Blueprint $table) {
            $table->double('gross_purchase', 15, 4)->nullable();
            $table->double('total_less_discount', 15, 4)->nullable();
            $table->double('bo_discount', 15, 4)->nullable();
            $table->double('vatable_purchase', 15, 4)->nullable();
            $table->double('vat', 15, 4)->nullable();
            $table->double('freight', 15, 4)->nullable();
            $table->double('total_final_cost', 15, 4)->nullable();
            $table->double('total_less_other_discount', 15, 4)->nullable();
            $table->double('net_payable', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Purchase_orders', function (Blueprint $table) {
            $table->dropColumn('gross_purchase');
            $table->dropColumn('total_less_discount');
            $table->dropColumn('bo_discount');
            $table->dropColumn('vatable_purchase');
            $table->dropColumn('vat');
            $table->dropColumn('freight');
            $table->dropColumn('total_final_cost');
            $table->dropColumn('total_less_other_discount');
            $table->dropColumn('net_payable');
        });
    }
}
