<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToReturnGoodStockDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Return_good_stock_details', function (Blueprint $table) {
            $table->integer('confirmed_quantity')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('scanned_by')->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Return_good_stock_details', function (Blueprint $table) {
            $table->dropColumn('confirmed_quantity');
            $table->dropColumn('remarks');
            $table->dropColumn('scanned_by');
            $table->dropColumn('user_id');
        });
    }
}
