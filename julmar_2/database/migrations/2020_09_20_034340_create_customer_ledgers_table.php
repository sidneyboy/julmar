<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
             $table->bigInteger('customer_payment_id');
             $table->bigInteger('van_selling_payment_id');
            $table->Integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->string('sales_order_number');
            $table->string('transaction_reference');
            $table->double('accounts_receivable_previous',15,4);
            $table->double('sales',15,4);
            $table->double('payment',15,4);
            $table->double('bo',15,4);
            $table->double('rgs',15,4);
            $table->double('adjustments',15,4);
            $table->double('accounts_receivable_end',15,4);
            $table->double('credit_line_amount');
            $table->double('credit_line_balance');
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
        Schema::dropIfExists('customer_ledgers');
    }
}
