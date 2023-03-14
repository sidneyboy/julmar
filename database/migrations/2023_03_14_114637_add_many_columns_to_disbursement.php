<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToDisbursement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Disbursements', function (Blueprint $table) {
            $table->string('payee')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->string('title')->nullable();
            $table->string('debit')->nullable();
            $table->string('credit')->nullable();
            $table->string('particulars')->nullable();
            $table->string('cv_number')->nullable();
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
        Schema::table('Disbursements', function (Blueprint $table) {
            $table->dropColumn('payee');
            $table->dropColumn('amount_in_words');
            $table->dropColumn('title');
            $table->dropColumn('debit');
            $table->dropColumn('credit');
            $table->dropColumn('particulars');
            $table->dropColumn('cv_number');
            $table->dropColumn('remarks');
        });
    }
}
