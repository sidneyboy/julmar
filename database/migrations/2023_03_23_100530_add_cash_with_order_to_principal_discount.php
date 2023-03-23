<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCashWithOrderToPrincipalDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Principal_discounts', function (Blueprint $table) {
            $table->double('cash_with_order_discount',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Principal_discounts', function (Blueprint $table) {
            $table->double('cash_with_order_discount');
        });
    }
}
