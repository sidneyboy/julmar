<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingLedgerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_ledger_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->Integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('sku_categories');
            $table->string('sku_type');
            $table->string('transaction');
            $table->string('sold_to');
            $table->integer('quantity');
            $table->integer('sold');
            $table->integer('running_balance');
            $table->double('price',15,4);
            $table->double('amount',15,4);
            $table->double('sales',15,4);
            $table->double('accounts_payable',15,4);
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('date');
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
        Schema::dropIfExists('van_selling_ledger_models');
    }
}
