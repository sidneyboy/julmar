<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateTimeToGeneralLedgers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('General_ledgers', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->time('time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('General_ledgers', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('time');
        });
    }
}
