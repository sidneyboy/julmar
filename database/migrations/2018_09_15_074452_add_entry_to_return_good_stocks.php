<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntryToReturnGoodStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Return_good_stocks', function (Blueprint $table) {
            $table->decimal('sales_return_and_allowances',15,4)->nullable();
            $table->decimal('accounts_receivable',15,4)->nullable();
            $table->decimal('inventory',15,4)->nullable();
            $table->decimal('cost_of_goods_sold',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Return_good_stocks', function (Blueprint $table) {
            $table->dropColumn('sales_return_and_allowances');
            $table->dropColumn('accounts_receivable');
            $table->dropColumn('inventory');
            $table->dropColumn('cost_of_goods_sold');
        });
    }
}
