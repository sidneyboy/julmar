<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCwoDiscountToInvoiceAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Invoice_cost_adjustments', function (Blueprint $table) {
            $table->double('cwo_discount',15,4)->nullable();
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
            $table->dropColumn('cwo_discount');
        });
    }
}
