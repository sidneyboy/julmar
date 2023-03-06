<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceRawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_raws', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_data');
            $table->string('delivery_receipt');
            $table->string('sales_representative');
            $table->string('sku_code');
            $table->longText('description');
            $table->integer('quantity');
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
        Schema::dropIfExists('invoice_raws');
    }
}
