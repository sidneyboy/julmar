<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoAllowanceDiscountRateToPurchaseOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Purchase_orders', function (Blueprint $table) {
            $table->double('bo_allowance_discount_rate',3,2)->nullable();
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
            $table->dropColumn('bo_allowance_discount_rate');
        });
    }
}
