<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity')->nullable();
            $table->integer('running_balance')->nullable();
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
        Schema::dropIfExists('sku_ledgers');
    }
}
