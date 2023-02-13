<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckAndSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_and_sales_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('truck_id')->unsigned()->index();
            $table->foreign('truck_id')->references('id')->on('trucks');
            $table->string('driver');
            $table->string('assistant');
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
        Schema::dropIfExists('truck_and_sales_invoices');
    }
}
