<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTruckAndSalesInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Truck_and_sales_invoices', function (Blueprint $table) {
            $table->date('departure_date')->nullable();
            $table->string('departure_time')->nullable();
            $table->date('arrival_date')->nullable();
            $table->string('arrival_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Truck_and_sales_invoices', function (Blueprint $table) {
            $table->dropColumn('departure_date')->nullable();
            $table->dropColumn('departure_time')->nullable();
            $table->dropColumn('arrival_date')->nullable();
            $table->dropColumn('arrival_time')->nullable();
        });
    }
}
