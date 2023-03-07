<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnGoodStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_good_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_receipt');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('principal_id')->unsigned()->nullable()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->string('sku_type');
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
        Schema::dropIfExists('return_good_stocks');
    }
}
