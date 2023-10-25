<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVsOsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vs_os_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vs_os_id')->unsigned()->nullable()->index();
            $table->foreign('vs_os_id')->references('id')->on('Vs_os_datas');
            $table->integer('sku_id')->unsigned()->index();
            $table->foreign('sku_id')->references('id')->on('sku_adds');
            $table->string('store_name');
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
        Schema::dropIfExists('vs_os_details');
    }
}
