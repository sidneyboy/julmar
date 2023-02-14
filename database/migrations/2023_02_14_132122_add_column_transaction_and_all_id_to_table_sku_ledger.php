<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTransactionAndAllIdToTableSkuLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sku_ledgers', function (Blueprint $table) {
            $table->string('transaction_type')->nullable();
            $table->integer('all_id')->nullable();
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
            $table->dropColumn('transaction_type');
            $table->dropColumn('all_id');
        });
    }
}
