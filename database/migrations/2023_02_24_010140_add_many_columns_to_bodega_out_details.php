<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToBodegaOutDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bodega_out_details', function (Blueprint $table) {
            $table->Integer('out_from_sku_id')->unsigned()->index();
            $table->foreign('out_from_sku_id')->references('id')->on('sku_adds');
            $table->integer('out_from_quantity');
            $table->Integer('in_to_sku_id')->unsigned()->index();
            $table->foreign('in_to_sku_id')->references('id')->on('sku_adds');
            $table->integer('in_to_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Bodega_out_details', function (Blueprint $table) {
            $table->dropColumn('out_from_sku_id');
            $table->dropColumn('out_from_quantity');
            $table->dropColumn('in_to_sku_id');
            $table->dropColumn('in_to_quantity');
        });
    }
}
