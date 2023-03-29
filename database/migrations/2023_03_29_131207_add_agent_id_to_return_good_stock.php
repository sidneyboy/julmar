<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdToReturnGoodStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Return_good_stocks', function (Blueprint $table) {
            $table->bigInteger('agent_id')->unsigned()->nullable()->index();
            $table->foreign('agent_id')->references('id')->on('agents');
            $table->bigInteger('customer_id')->unsigned()->nullable()->index();
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Return_good_stocks', function (Blueprint $table) {
            $table->dropColumn('agent_id');
            $table->dropColumn('customer_id');
        });
    }
}
