<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingPcmDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_pcm_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('van_selling_pcm_id')->unsigned()->index();
            $table->foreign('van_selling_pcm_id')->references('id')->on('van_selling_pcms');
            $table->string('sku_code');
            $table->string('description');
            $table->string('principal');
            $table->double('unit_price',15,4);
            $table->Integer('quantity');
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
        Schema::dropIfExists('van_selling_pcm_details');
    }
}
