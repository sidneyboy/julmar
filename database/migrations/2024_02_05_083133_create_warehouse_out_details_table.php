<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseOutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_out_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('warehouse_out_id')->unsigned()->nullable()->index();
            $table->foreign('warehouse_out_id')->references('id')->on('warehouse_outs');
            $table->integer('sku_id')->unsigned()->nullable()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
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
        Schema::dropIfExists('warehouse_out_details');
    }
}
