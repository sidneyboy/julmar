<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegaOutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_out_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bodega_out_id')->unsigned()->index();
            $table->foreign('bodega_out_id')->references('id')->on('bodega_outs');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->Integer('quantity');
            $table->string('fuc_prices', 50);
            $table->Integer('transfer_to_sku_id');
            $table->Integer('transfer_quantity');
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
        Schema::dropIfExists('bodega_out_details');
    }
}
