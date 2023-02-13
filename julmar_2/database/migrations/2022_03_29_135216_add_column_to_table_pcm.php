<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToTablePcm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Van_selling_pcms', function (Blueprint $table) {
            $table->string('remitted_by');
            $table->string('store_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Van_selling_pcms', function (Blueprint $table) {
            $table->dropColumn('remitted_by');
            $table->dropColumn('store_name');
        });
    }
}
