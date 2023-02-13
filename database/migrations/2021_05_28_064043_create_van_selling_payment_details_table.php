<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('van_selling_payment_id')->unsigned()->index();
            $table->foreign('van_selling_payment_id')->references('id')->on('van_selling_payments');
            $table->BigInteger('van_selling_printed_id')->unsigned()->index();
            $table->foreign('van_selling_printed_id')->references('id')->on('van_selling_printeds');
            $table->double('amount',15,4);
            $table->double('balance',15,4);
             $table->text('remarks');
               $table->text('status');
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
        Schema::dropIfExists('van_selling_payment_details');
    }
}
