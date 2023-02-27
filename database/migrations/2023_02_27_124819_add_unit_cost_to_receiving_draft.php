<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitCostToReceivingDraft extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Receiving_drafts', function (Blueprint $table) {
            $table->double('unit_cost', 15, 4)->nullable();
            $table->double('freight', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Receiving_drafts', function (Blueprint $table) {
            $table->dropColumn('unit_cost');
            $table->dropColumn('freight');
        });
    }
}
