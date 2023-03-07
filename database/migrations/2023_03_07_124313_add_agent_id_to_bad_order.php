<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgentIdToBadOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            $table->bigInteger('agent_id')->unsigned()->index();
            $table->foreign('agent_id')->references('id')->on('Agents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Bad_orders', function (Blueprint $table) {
            //
        });
    }
}
