<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWithInvoiceQuantityToSkuLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sku_ledgers', function (Blueprint $table) {
            $table->integer('with_invoice_quantity')->nullable();
            $table->integer('with_invoice_net_balance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Sku_ledgers', function (Blueprint $table) {
            $table->dropColumn('with_invoice_quantity');
            $table->dropColumn('with_invoice_net_balance');
        });
    }
}
