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
            $table->integer('principal_id')->unsigned()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('sku_categories');
            $table->string('sku_type',20);
            $table->string('in_out_adjustments',20);
            $table->string('rr_dr',50);
            $table->string('sales_order_number',50);
            $table->string('principal_invoice',50);
            $table->integer('quantity');
            $table->integer('running_balance');
            $table->double('unit_cost',15,4);
            $table->double('total_cost',15,4);
            $table->double('adjustments',15,4);
            $table->double('running_total_cost',15,4);
            $table->double('final_unit_cost',15,4);
            $table->date('transaction_date')->index();
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
