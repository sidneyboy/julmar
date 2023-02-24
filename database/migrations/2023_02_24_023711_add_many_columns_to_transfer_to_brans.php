<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnsToTransferToBrans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Transfer_to_brans', function (Blueprint $table) {
            $table->string('transfer_from');
            $table->string('transfer_to');
            $table->double('total_amount',15,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Transfer_to_brans', function (Blueprint $table) {
            $table->dropColumn('transfer_from');
            $table->dropColumn('transfer_to');
            $table->dropColumn('total_amount');
        });
    }
}
