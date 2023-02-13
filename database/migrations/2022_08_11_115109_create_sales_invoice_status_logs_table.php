<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInvoiceStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_status_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('sales_invoice_id')->unsigned()->index();
            $table->foreign('sales_invoice_id')->references('id')->on('sales_invoices');
            $table->date('posted')->nullable();
            $table->date('updated')->nullable();
            $table->string('status', 100);
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
        Schema::dropIfExists('sales_invoice_status_logs');
    }
}
