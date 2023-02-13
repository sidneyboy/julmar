<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcmUploadVsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcm_upload_vs_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('pcm_upload_vs_id')->unsigned()->index();
            $table->foreign('pcm_upload_vs_id')->references('id')->on('pcm_upload_vs');
            $table->string('sku_code');
            $table->Integer('rgs_quantity');
            $table->Integer('bo_quantity');
            $table->string('unit_price');
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
        Schema::dropIfExists('pcm_upload_vs_details');
    }
}
