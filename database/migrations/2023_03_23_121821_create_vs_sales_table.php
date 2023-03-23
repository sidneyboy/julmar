<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('principal_id')->unsigned()->nullable()->index();
            $table->foreign('principal_id')->references('id')->on('sku_principals');
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->longText('customer_store_name');
            $table->string('reference');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
            $table->double('unit_price',15,4);
            $table->string('area')->nullable();
            $table->string('location')->nullable();
            $table->string('date_sold');
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
        Schema::dropIfExists('vs_sales');
    }
}
