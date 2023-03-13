<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumntToPurchaseOrderSalesOrderNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Purchase_orders', function (Blueprint $table) {
            $table->string('van_number')->nullable();
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
            $table->dropColumn('van_number')->nullable();
        });
    }
}
