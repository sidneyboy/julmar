<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingArLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_ar_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('van_selling_print_id')->unsigned()->index();
            $table->foreign('van_selling_print_id')->references('id')->on('van_selling_printeds')->nullable();
            $table->BigInteger('vs_inv_adj_id')->unsigned()->index();
            $table->foreign('vs_inv_adj_id')->references('id')->on('van_selling_printeds');
            $table->BigInteger('van_selling_payment_id')->unsigned()->index();
            $table->foreign('van_selling_payment_id')->references('id')->on('van_selling_payments');
            $table->integer('principal_id')->unsigned()->index()->nullable();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->date('date')->index();
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
        Schema::dropIfExists('van_selling_ar_ledgers');
    }
}
