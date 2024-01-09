<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntryToBadOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            $table->decimal('spoiled_goods',15,4)->nullable();
            $table->decimal('accounts_receivable',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            $table->dropColumn('spoiled_goods');
            $table->dropColumn('accounts_receivable');
        });
    }
}
