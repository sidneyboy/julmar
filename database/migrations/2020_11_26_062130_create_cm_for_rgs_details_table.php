<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmForRgsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_for_rgs_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('cm_for_rgs_id')->unsigned()->index();
            $table->foreign('cm_for_rgs_id')->references('id')->on('cm_for_rgs');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->Integer('quantity');
            $table->double('price',15,4);
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
        Schema::dropIfExists('cm_for_rgs_details');
    }
}
