<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiIdToBadOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            $table->bigInteger('si_id')->unsigned()->nullable()->index();
            $table->foreign('si_id')->references('id')->on('Sales_invoices');
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
            $table->dropColumn('si_id');
        });
    }
}
