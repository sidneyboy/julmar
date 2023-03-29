<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalToReturnGoodStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Return_good_stocks', function (Blueprint $table) {
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
        Schema::table('Return_good_stocks', function (Blueprint $table) {
            $table->dropColumn('total_amount');
        });
    }
}
