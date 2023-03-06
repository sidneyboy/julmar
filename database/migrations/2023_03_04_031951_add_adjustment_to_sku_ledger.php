<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdjustmentToSkuLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sku_ledgers', function (Blueprint $table) {
            $table->integer('adjustments')->nullable();
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Sku_ledgers', function (Blueprint $table) {
            $table->dropColumn('adjustments');
            $table->dropColumn('remarks');
        });
    }
}
