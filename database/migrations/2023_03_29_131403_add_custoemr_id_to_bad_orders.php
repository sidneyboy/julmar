<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustoemrIdToBadOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
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
            $table->dropColumn('customer_id');
        });
    }
}
