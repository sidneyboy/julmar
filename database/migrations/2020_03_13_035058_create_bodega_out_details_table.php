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
