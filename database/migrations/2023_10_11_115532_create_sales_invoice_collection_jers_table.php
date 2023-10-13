<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceCollectionJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_collection_jers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sicrd_id')->unsigned()->nullable()->index();
            $table->foreign('sicrd_id')->references('id')->on('sales_invoice_collection_receipts');
            $table->double('debit_record', 15, 4);
            $table->double('credit_record', 15, 4);
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
        Schema::dropIfExists('sales_invoice_collection_jers');
    }
}
