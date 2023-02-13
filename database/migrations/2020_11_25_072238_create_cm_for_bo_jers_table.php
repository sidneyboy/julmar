<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmForBoJersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_for_bo_jers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('cm_for_bo_id')->unsigned()->index();
            $table->foreign('cm_for_bo_id')->references('id')->on('cm_for_bos');
            $table->double('sales',15,4);
            $table->double('accounts_receivable',15,4);
            $table->double('sales_return_and_allowances',15,4);
            $table->double('cost_of_sales',15,4);
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
        Schema::dropIfExists('cm_for_bo_jers');
    }
}
