<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogisticsDetailsIdToLogisticsInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Logistics_invoices', function (Blueprint $table) {
            $table->bigInteger('logistics_details_id')->unsigned()->nullable()->index();
            $table->foreign('logistics_details_id')->references('id')->on('logistics_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Logistics_invoices', function (Blueprint $table) {
            $table->dropColumn('logistics_details_id');
        });
    }
}
