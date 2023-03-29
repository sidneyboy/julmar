<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPcmToReturnGoodStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Return_good_stocks', function (Blueprint $table) {
            $table->string('pcm_number');
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
            $table->dropColumn('pcm_number');
        });
    }
}
