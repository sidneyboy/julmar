<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOutstandingBalanceToTableVanSellingArLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Van_selling_ar_ledgers', function (Blueprint $table) {
            $table->double('outstanding_balance',15,4);
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
            $table->dropColumn('outstanding_balance');
        });
    }
}
