<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrincipalLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('principal_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->string('rr_dr');
            $table->string('principal_invoice');
            $table->string('transaction');
            $table->double('accounts_payable_beginning',15,4);
            $table->double('received',15,4);
            $table->double('returned',15,4);
            $table->double('adjustment',15,4);
            $table->double('payment',15,4);
            $table->double('accounts_payable_end',15,4);
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
        Schema::dropIfExists('principal_ledgers');
    }
}
