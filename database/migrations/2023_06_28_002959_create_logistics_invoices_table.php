<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistics_invoices', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('logistics_id')->unsigned()->nullable()->index();
            $table->foreign('logistics_id')->references('id')->on('logistics');
            $table->BigInteger('sales_invoice_id')->unsigned()->nullable()->index();
            $table->foreign('sales_invoice_id')->references('id')->on('sales_invoices');
            $table->Integer('principal_id')->unsigned()->nullable()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->double('case', 15, 4);
            $table->double('butal', 15, 4);
            $table->double('conversion', 15, 4);
            $table->double('amount', 15, 4);
            $table->double('percentage', 15, 4);
            $table->double('equivalent', 15, 4)->nullable();
            $table->double('weight', 15, 4)->nullable();
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
        Schema::dropIfExists('logistics_invoices');
    }
}
