<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNormalBalanceToChartOfAccountsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Chart_of_accounts_details', function (Blueprint $table) {
            $table->string('normal_balance',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Chart_of_account_details', function (Blueprint $table) {
            $table->dropColumn('normal_balance');
        });
    }
}
