<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoAllowanceAdjustmentsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bo_allowance_adjustments_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bo_allowance_id')->unsigned()->index();
            $table->foreign('bo_allowance_id')->references('id')->on('bo_allowance_adjustments');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
            $table->float('unit_cost',15,4)->nullable();
            $table->float('adjusted_amount', 15,4);
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
        Schema::dropIfExists('bo_allowance_adjustments_details');
    }
}
