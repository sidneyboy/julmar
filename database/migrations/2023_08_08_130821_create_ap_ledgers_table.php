<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ap_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('principal_id')->unsigned()->nullable()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('transaction_date')->nullable();
            $table->string('description',100);
            $table->double('debit_record',15,4);
            $table->double('credit_record',15,4);
            $table->double('running_balance',15,4);
            $table->string('transaction');
            $table->integer('reference');
            $table->string('remarks')->nullable();
            $table->string('close_date')->nullable();
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
        Schema::dropIfExists('ap_ledgers');
    }
}
