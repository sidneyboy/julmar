<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferToBransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_to_brans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('received_id')->unsigned()->index();
            $table->foreign('received_id')->references('id')->on('received_purchase_orders');
            $table->Integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('transfer_to_brans');
    }
}
