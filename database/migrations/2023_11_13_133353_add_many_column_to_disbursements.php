<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColumnToDisbursements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Disbursements', function (Blueprint $table) {
            $table->double('ewt_amount',15,4)->nullable();
            $table->double('net_payable',15,4)->nullable();
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
            //
        });
    }
}
