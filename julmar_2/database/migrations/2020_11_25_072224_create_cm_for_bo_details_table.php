<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmForBoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_for_bo_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('cm_for_bo_id')->unsigned()->index();
            $table->foreign('cm_for_bo_id')->references('id')->on('cm_for_bos');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
            $table->double('price',15,4);
            $table->double('bo_amount',15,4);
            $table->string('remarks');
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
        Schema::dropIfExists('cm_for_bo_details');
    }
}
