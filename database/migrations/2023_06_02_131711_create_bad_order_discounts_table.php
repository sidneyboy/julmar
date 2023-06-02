<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadOrderDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bad_order_discounts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('bad_order_id')->unsigned()->index();
            $table->foreign('bad_order_id')->references('id')->on('bad_orders');
            $table->double('discount_rate',5,2);
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
        Schema::dropIfExists('bad_order_discounts');
    }
}
