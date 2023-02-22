<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToPrincipalPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Principal_payments', function (Blueprint $table) {
            $table->double('current_accounts_payable_final',15,4);
            $table->integer('user_id');
            $table->string('cheque_number');
            $table->string('disbursement_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Principal_payments', function (Blueprint $table) {
            $table->dropColumn('current_accounts_payable_final',15,4);
            $table->dropColumn('user_id');
            $table->dropColumn('cheque_number');
            $table->dropColumn('disbursement_number');
        });
    }
}
