<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->BigInteger('agent_id')->unsigned()->index();
            $table->foreign('agent_id')->references('id')->on('agents');
            $table->BigInteger('cm_for_bo_id')->unsigned()->index();
            $table->foreign('cm_for_bo_id')->references('id')->on('cm_for_bos');
            $table->BigInteger('cm_for_rgs_id')->unsigned()->index();
            $table->foreign('cm_for_rgs_id')->references('id')->on('cm_for_rgs');
            $table->BigInteger('customer_payment_details_id')->unsigned()->index();
            $table->foreign('customer_payment_details_id')->references('id')->on('customer_payment_details');
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
        Schema::dropIfExists('ar_ledgers');
    }
}
