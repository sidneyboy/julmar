<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckAndSalesInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_and_sales_invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('truck_si_id')->unsigned()->index();
            $table->foreign('truck_si_id')->references('id')->on('truck_and_sales_invoices');
            $table->BigInteger('sales_invoice_id')->unsigned()->index();
            $table->foreign('sales_invoice_id')->references('id')->on('sales_invoices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truck_and_sales_invoice_details');
    }
}
