<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_jers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sales_invoice_id')->unsigned()->nullable()->index();
            $table->foreign('sales_invoice_id')->references('id')->on('sales_invoices');
            $table->double('debit_record_ar',15,4);
            $table->double('credit_record_sales',15,4);
            $table->double('debit_record_cost_of_sales',15,4);
            $table->double('credit_record_inventory',15,4);
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
        Schema::dropIfExists('sales_invoice_jers');
    }
}
