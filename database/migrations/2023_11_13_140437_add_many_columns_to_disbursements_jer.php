<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToDisbursementsJer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Disbursement_jers', function (Blueprint $table) {
            $table->double('accounts_payable', 15, 4)->nullable();
            $table->double('cash_in_bank', 15, 4)->nullable();
            $table->double('withholding_tax', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Disbursement_jers', function (Blueprint $table) {
            $table->dropColumn('accounts_payable');
            $table->dropColumn('cash_in_bank');
            $table->dropColumn('withholding_tax');
        });
    }
}
