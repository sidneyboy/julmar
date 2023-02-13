<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePcmUploadDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcm_upload_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('pcm_upload_id')->unsigned()->index();
            $table->foreign('pcm_upload_id')->references('id')->on('pcm_uploads');
            $table->Integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->Integer('rgs_quantity');
            $table->Integer('bo_quantity');
            $table->double('unit_price');
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
        Schema::dropIfExists('pcm_upload_details');
    }
}
