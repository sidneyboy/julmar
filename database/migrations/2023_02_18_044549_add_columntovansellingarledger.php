<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumntovansellingarledger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Van_selling_ar_ledgers', function (Blueprint $table) {
            $table->double('running_balance',15,4)->nullable();
            $table->integer('van_selling_pcm_id')->nullable();
            $table->double('adjustments',15,4)->nullable();
            $table->double('sku_price_adjustments',15,4)->nullable();
            $table->double('cm_amount',15,4)->nullable();
            $table->double('price_update',15,4)->nullable();
            $table->double('actual_stocks_on_hand',15,4)->nullable();
            $table->double('charge_payment',15,4)->nullable();
            $table->double('amount',15,4)->nullable();
            $table->double('collection',15,4)->nullable();
            $table->double('over_short',15,4)->nullable();
            $table->double('should_be',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Van_selling_ar_ledgers', function (Blueprint $table) {
            //
        });
    }
}
