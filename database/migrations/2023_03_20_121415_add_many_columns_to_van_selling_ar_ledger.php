<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToVanSellingArLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Van_selling_ar_ledgers', function (Blueprint $table) {
            $table->string('transaction')->nullable();
            $table->bigInteger('all_id')->nullable();
            $table->double('running_balance',15,4)->nullable();
            $table->double('amount',15,4)->nullable();
            $table->double('short',15,4)->nullable();
            // $table->double('outstanding_balance',15,4)->nullable();
            // $table->string('remarks')->nullable();
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
            $table->dropColumn('transaction');
            $table->dropColumn('all_id');
            $table->dropColumn('running_balance');
            $table->dropColumn('amount');
            $table->dropColumn('short');
            // $table->dropColumn('outstanding_balance');
            // $table->dropColumn('remarks');
        });
    }
}
