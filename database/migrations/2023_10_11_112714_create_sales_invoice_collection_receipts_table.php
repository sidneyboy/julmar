<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceCollectionReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_collection_receipts', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->bigInteger('agent_id')->unsigned()->nullable()->index();
            $table->foreign('agent_id')->references('id')->on('agents');
            $table->string('check_ref_cash', 50)->nullable();
            $table->string('official_receipt', 50)->nullable();
            $table->string('bank', 20);
            $table->string('payment_date', 15);
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
        Schema::dropIfExists('sales_invoice_collection_receipts');
    }
}
