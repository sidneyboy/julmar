<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceCollectionReceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_collection_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sicrd_id')->unsigned()->nullable()->index();
            $table->foreign('sicrd_id')->references('id')->on('sales_invoice_collection_receipts');
            $table->bigInteger('si_id')->unsigned()->nullable()->index();
            $table->foreign('si_id')->references('id')->on('sales_invoices');
            $table->double('ar_balance', 15, 4);
            $table->double('amount_collected', 15, 4);
            $table->double('outstanding_balance', 15, 4);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('sales_invoice_collection_receipt_details');
    }
}
