<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('main_category_id')->unsigned()->index();
            $table->foreign('main_category_id')->references('id')->on('sku_categories');
            $table->string('sub_category');
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
        Schema::dropIfExists('sku_sub_categories');
    }
}
