<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsPcmDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_pcm_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vs_pcm_id')->unsigned()->nullable()->index();
            $table->foreign('vs_pcm_id')->references('id')->on('vs_pcms');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->integer('quantity');
            $table->double('unit_price',15,4)->nullable();
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
        Schema::dropIfExists('vs_pcm_details');
    }
}
