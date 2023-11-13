<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnToDisbursements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Disbursements', function (Blueprint $table) {
            $table->double('payable_amount', 15, 4)->nullable();
            $table->double('ewt_amount', 15, 4)->nullable();
            $table->double('net_payable', 15, 4)->nullable();
            $table->double('amount_paid', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Disbursements', function (Blueprint $table) {
            $table->dropColumn('payable_amount');
            $table->dropColumn('ewt_amount');
            $table->dropColumn('net_payable');
            $table->dropColumn('amount_paid');
        });
    }
}
