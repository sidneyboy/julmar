<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllIdToGeneralLedgers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('General_ledgers', function (Blueprint $table) {
            $table->bigInteger('all_id')->nullable();
            $table->string('description')->nullable();
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
            $table->dropColumn('all_id');
            $table->dropColumn('description');
        });
    }
}
