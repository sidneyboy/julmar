<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalExpenseToLogistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Logistics', function (Blueprint $table) {
            $table->integer('total_expense_updated_by')->unsigned()->nullable()->index();
            $table->foreign('total_expense_updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Logistics', function (Blueprint $table) {
            $table->dropColumn('total_expense_updated_by');
        });
    }
}
