<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanSellingOsDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_selling_os_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name');
            $table->string('sku_code');
            $table->string('description');
            $table->Integer('quantity');
            $table->double('os_unit_price',15,4);
            $table->double('os_sub_total',15,4);
            $table->string('os_date')->nullable();
            $table->Integer('served_quantity')->nullable();
            $table->double('served_unit_price',15,4)->nullable();
            $table->double('served_sub_total',15,4)->nullable();
            $table->string('served_date')->nullable();
            $table->string('principal');
            $table->string('os_code');
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
        Schema::dropIfExists('van_selling_os_datas');
    }
}
