<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkuCodeToVsWithdrawalDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Vs_withdrawal_details', function (Blueprint $table) {
            $table->string('sku_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Vs_withdrawal_details', function (Blueprint $table) {
            $table->dropColumn('sku_code');
        });
    }
}
