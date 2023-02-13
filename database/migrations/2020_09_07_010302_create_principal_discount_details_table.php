<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrincipalDiscountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('principal_discount_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('principal_discount_id')->unsigned()->index();
            $table->foreign('principal_discount_id')->references('id')->on('principal_discounts');
            $table->string('discount_name');
            $table->double('discount_rate');
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
        Schema::dropIfExists('principal_discount_details');
    }
}
