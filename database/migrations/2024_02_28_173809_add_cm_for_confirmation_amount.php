<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCmForConfirmationAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Sales_invoices', function (Blueprint $table) {
            $table->float('cm_for_confirmation_amount',15,4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Sales_invoices', function (Blueprint $table) {
            $table->dropColumn('cm_for_confirmation_amount');
        });
    }
}
