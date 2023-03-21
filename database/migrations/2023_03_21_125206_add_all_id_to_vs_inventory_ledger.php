<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllIdToVsInventoryLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Vs_inventory_ledgers', function (Blueprint $table) {
            $table->string('all_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Vs_inventory_ledgers', function (Blueprint $table) {
            $table->dropColumn('all_id');
        });
    }
}
