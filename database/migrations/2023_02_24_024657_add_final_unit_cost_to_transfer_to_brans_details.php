<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalUnitCostToTransferToBransDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Transfer_to_bran_details', function (Blueprint $table) {
            $table->double('final_unit_cost',15,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Transfer_to_bran_details', function (Blueprint $table) {
            $table->dropColumn('final_unit_cost');
        });
    }
}
