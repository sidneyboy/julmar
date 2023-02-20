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
            $table->string('all_id');
            $table->string('transaction');
            $table->double('accounts_payable_beginning',15,4)->nullable();
            $table->double('received',15,4)->nullable();
            $table->double('returned',15,4)->nullable();
            $table->double('adjustment',15,4)->nullable();
            $table->double('payment',15,4)->nullable();
            $table->double('accounts_payable_end',15,4)->nullable();
            $table->date('date')->index()->nullable();
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
