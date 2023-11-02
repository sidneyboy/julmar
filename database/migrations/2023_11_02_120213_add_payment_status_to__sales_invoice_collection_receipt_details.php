<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToSalesInvoiceCollectionReceiptDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sales_invoice_collection_receipt_details', function (Blueprint $table) {
            $table->string('payment_status',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Sales_invoice_collection_receipt_details', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });
    }
}
